<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService
{
    /**
     * Create a payment for a booking
     */
    public function createPayment(Booking $booking, array $paymentData): Payment
    {
        return Payment::create([
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id ?? $paymentData['user_id'],
            'amount' => $paymentData['amount'],
            'payment_method' => $paymentData['payment_method'],
            'payment_provider' => $paymentData['payment_provider'] ?? null,
            'payment_reference' => $this->generatePaymentReference(),
            'status' => 'pending',
        ]);
    }

    /**
     * Process mobile money payment (placeholder implementation)
     */
    public function processMobileMoneyPayment(Payment $payment, array $details): array
    {
        // Simulate API call to mobile money provider
        // In production, this would integrate with actual APIs
        
        $provider = $payment->payment_provider;
        $phoneNumber = $details['phone_number'] ?? '';
        
        // Simulate processing delay
        sleep(1);
        
        // Simulate success (90% success rate for testing)
        $success = rand(1, 10) <= 9;
        
        if ($success) {
            $transactionId = $this->generateTransactionId($provider);
            
            $payment->update([
                'status' => 'completed',
                'transaction_id' => $transactionId,
                'paid_at' => now(),
                'payment_details' => [
                    'provider' => $provider,
                    'phone_number' => $phoneNumber,
                    'transaction_id' => $transactionId,
                    'processed_at' => now()->toISOString(),
                ],
            ]);
            
            // Update booking payment status
            $this->updateBookingPaymentStatus($payment->booking);
            
            return [
                'success' => true,
                'message' => 'Payment processed successfully',
                'transaction_id' => $transactionId,
            ];
        } else {
            $payment->markAsFailed('Payment declined by provider');
            
            return [
                'success' => false,
                'message' => 'Payment failed. Please try again.',
            ];
        }
    }

    /**
     * Process card payment (placeholder implementation)
     */
    public function processCardPayment(Payment $payment, array $details): array
    {
        // Simulate API call to card payment gateway
        // In production, this would integrate with Visa/Mastercard gateway
        
        $cardNumber = $details['card_number'] ?? '';
        $cvv = $details['cvv'] ?? '';
        $expiryDate = $details['expiry_date'] ?? '';
        
        // Basic validation
        if (strlen($cardNumber) < 15 || strlen($cvv) < 3) {
            return [
                'success' => false,
                'message' => 'Invalid card details',
            ];
        }
        
        // Simulate processing delay
        sleep(1);
        
        // Simulate success (85% success rate for testing)
        $success = rand(1, 10) <= 8;
        
        if ($success) {
            $transactionId = $this->generateTransactionId('card');
            
            $payment->update([
                'status' => 'completed',
                'transaction_id' => $transactionId,
                'paid_at' => now(),
                'payment_details' => [
                    'card_last_four' => substr($cardNumber, -4),
                    'card_type' => $this->detectCardType($cardNumber),
                    'transaction_id' => $transactionId,
                    'processed_at' => now()->toISOString(),
                ],
            ]);
            
            // Update booking payment status
            $this->updateBookingPaymentStatus($payment->booking);
            
            return [
                'success' => true,
                'message' => 'Payment processed successfully',
                'transaction_id' => $transactionId,
            ];
        } else {
            $payment->markAsFailed('Card declined');
            
            return [
                'success' => false,
                'message' => 'Card payment declined. Please check your details and try again.',
            ];
        }
    }

    /**
     * Process bank transfer payment (manual confirmation)
     */
    public function processBankTransferPayment(Payment $payment, array $details): array
    {
        $payment->update([
            'status' => 'processing',
            'payment_details' => [
                'bank_name' => $details['bank_name'] ?? '',
                'account_number' => $details['account_number'] ?? '',
                'transfer_reference' => $details['transfer_reference'] ?? '',
                'submitted_at' => now()->toISOString(),
            ],
        ]);
        
        return [
            'success' => true,
            'message' => 'Bank transfer details submitted. Payment will be confirmed within 24-48 hours.',
            'requires_manual_verification' => true,
        ];
    }

    /**
     * Process cash payment (manual confirmation)
     */
    public function processCashPayment(Payment $payment): array
    {
        $payment->update([
            'status' => 'processing',
            'payment_details' => [
                'payment_method' => 'cash',
                'submitted_at' => now()->toISOString(),
            ],
        ]);
        
        return [
            'success' => true,
            'message' => 'Cash payment noted. Please contact the property owner to arrange payment.',
            'requires_manual_verification' => true,
        ];
    }

    /**
     * Generate unique payment reference
     */
    private function generatePaymentReference(): string
    {
        return 'PAY-' . strtoupper(Str::random(12));
    }

    /**
     * Generate transaction ID based on provider
     */
    private function generateTransactionId(string $provider): string
    {
        $prefix = match($provider) {
            'mobicash' => 'MC',
            'orange_money' => 'OM',
            'moov_money' => 'MM',
            'card' => 'CARD',
            default => 'TXN',
        };
        
        return $prefix . '-' . time() . '-' . strtoupper(Str::random(8));
    }

    /**
     * Detect card type from number
     */
    private function detectCardType(string $cardNumber): string
    {
        $firstDigit = substr($cardNumber, 0, 1);
        
        if ($firstDigit === '4') {
            return 'visa';
        } elseif (in_array($firstDigit, ['5', '2'])) {
            return 'mastercard';
        }
        
        return 'unknown';
    }

    /**
     * Update booking payment status after successful payment
     */
    private function updateBookingPaymentStatus(Booking $booking): void
    {
        $totalPaid = $booking->payments()->completed()->sum('amount');
        
        if ($totalPaid >= $booking->total_amount) {
            $booking->update([
                'payment_status' => 'completed',
                'payment_completed_at' => now(),
            ]);
        } elseif ($totalPaid > 0) {
            $booking->update([
                'payment_status' => 'partial',
            ]);
        }
    }

    /**
     * Get payment status for a booking
     */
    public function getBookingPaymentStatus(Booking $booking): array
    {
        $totalPaid = $booking->payments()->completed()->sum('amount');
        $totalDue = $booking->total_amount;
        $remaining = $totalDue - $totalPaid;
        
        return [
            'total_due' => $totalDue,
            'total_paid' => $totalPaid,
            'remaining' => max(0, $remaining),
            'is_fully_paid' => $remaining <= 0,
            'payment_status' => $booking->payment_status,
        ];
    }

    /**
     * Refund a payment (placeholder)
     */
    public function refundPayment(Payment $payment, string $reason = ''): array
    {
        if (!$payment->isCompleted()) {
            return [
                'success' => false,
                'message' => 'Only completed payments can be refunded',
            ];
        }
        
        // Simulate refund processing
        $payment->update([
            'status' => 'refunded',
            'payment_details' => array_merge($payment->payment_details ?? [], [
                'refunded_at' => now()->toISOString(),
                'refund_reason' => $reason,
            ]),
        ]);
        
        return [
            'success' => true,
            'message' => 'Payment refunded successfully',
        ];
    }
}

