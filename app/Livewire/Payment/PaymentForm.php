<?php

namespace App\Livewire\Payment;

use App\Models\Booking;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PaymentForm extends Component
{
    public $bookingId;
    public $booking;
    public $paymentStatus;
    
    // Payment details
    public $payment_method = 'mobile_money';
    public $payment_provider = '';
    public $amount;
    
    // Mobile Money fields
    public $phone_number = '';
    
    // Card fields
    public $card_number = '';
    public $card_holder = '';
    public $expiry_date = '';
    public $cvv = '';
    
    // Bank Transfer fields
    public $bank_name = '';
    public $account_number = '';
    public $transfer_reference = '';
    
    public $processing = false;
    public $paymentResult = null;

    public function mount($bookingId)
    {
        $this->bookingId = $bookingId;
        $this->booking = Booking::with('property')->findOrFail($bookingId);
        
        // Check authorization
        if (Auth::id() !== $this->booking->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        // Get payment status
        $paymentService = app(PaymentService::class);
        $this->paymentStatus = $paymentService->getBookingPaymentStatus($this->booking);
        
        // Set amount to remaining balance
        $this->amount = $this->paymentStatus['remaining'];
    }

    protected function rules()
    {
        $rules = [
            'payment_method' => 'required|in:mobile_money,card,bank_transfer,cash',
            'amount' => 'required|numeric|min:1|max:' . $this->paymentStatus['remaining'],
        ];
        
        if ($this->payment_method === 'mobile_money') {
            $rules['payment_provider'] = 'required|in:mobicash,orange_money,moov_money';
            $rules['phone_number'] = 'required|string';
        } elseif ($this->payment_method === 'card') {
            $rules['payment_provider'] = 'required|in:visa,mastercard';
            $rules['card_number'] = 'required|string|min:15|max:16';
            $rules['card_holder'] = 'required|string';
            $rules['expiry_date'] = 'required|string';
            $rules['cvv'] = 'required|string|min:3|max:4';
        } elseif ($this->payment_method === 'bank_transfer') {
            $rules['bank_name'] = 'required|string';
            $rules['transfer_reference'] = 'required|string';
        }
        
        return $rules;
    }

    public function updatedPaymentMethod()
    {
        $this->reset(['payment_provider', 'phone_number', 'card_number', 'card_holder', 'expiry_date', 'cvv', 'bank_name', 'account_number', 'transfer_reference']);
    }

    public function processPayment()
    {
        $this->validate();
        
        $this->processing = true;
        $this->paymentResult = null;
        
        try {
            $paymentService = app(PaymentService::class);
            
            // Create payment record
            $payment = $paymentService->createPayment($this->booking, [
                'user_id' => Auth::id(),
                'amount' => $this->amount,
                'payment_method' => $this->payment_method,
                'payment_provider' => $this->payment_provider ?: null,
            ]);
            
            // Process based on payment method
            $result = match($this->payment_method) {
                'mobile_money' => $paymentService->processMobileMoneyPayment($payment, [
                    'phone_number' => $this->phone_number,
                ]),
                'card' => $paymentService->processCardPayment($payment, [
                    'card_number' => $this->card_number,
                    'card_holder' => $this->card_holder,
                    'expiry_date' => $this->expiry_date,
                    'cvv' => $this->cvv,
                ]),
                'bank_transfer' => $paymentService->processBankTransferPayment($payment, [
                    'bank_name' => $this->bank_name,
                    'account_number' => $this->account_number,
                    'transfer_reference' => $this->transfer_reference,
                ]),
                'cash' => $paymentService->processCashPayment($payment),
                default => ['success' => false, 'message' => 'Invalid payment method'],
            };
            
            $this->paymentResult = $result;
            
            if ($result['success']) {
                // Refresh payment status
                $this->paymentStatus = $paymentService->getBookingPaymentStatus($this->booking->fresh());
                
                // Show success message
                session()->flash('success', $result['message']);
                
                // If fully paid, redirect after a delay
                if ($this->paymentStatus['is_fully_paid']) {
                    $this->dispatch('paymentCompleted');
                }
            } else {
                session()->flash('error', $result['message']);
            }
            
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while processing your payment. Please try again.');
            \Log::error('Payment processing error: ' . $e->getMessage());
        } finally {
            $this->processing = false;
        }
    }

    public function render()
    {
        return view('livewire.payment.payment-form')->layout('layouts.app');
    }
}
