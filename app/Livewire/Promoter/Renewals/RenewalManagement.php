<?php

namespace App\Livewire\Promoter\Renewals;

use App\Models\Booking;
use App\Models\Renewal;
use App\Services\RenewalService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class RenewalManagement extends Component
{
    use WithPagination;

    public $statusFilter = 'all';
    public $showInitiateForm = false;
    public $showRejectModal = false;
    public $renewalToReject = null;
    public $rejectionReason = '';
    
    // Initiate renewal form fields
    public $selectedBookingId = '';
    public $newEndDate = '';
    public $renewalDuration = 1;
    public $renewalFrequency = 'monthly';
    public $renewalAmount = '';
    public $notes = '';

    protected $rules = [
        'selectedBookingId' => 'required|exists:bookings,id',
        'newEndDate' => 'required|date|after:today',
        'renewalDuration' => 'required|integer|min:1',
        'renewalFrequency' => 'required|in:daily,weekly,monthly,yearly',
        'renewalAmount' => 'required|numeric|min:0',
        'notes' => 'nullable|string',
    ];

    protected $rejectRules = [
        'rejectionReason' => 'required|string|min:10',
    ];

    public function render()
    {
        $promoter = Auth::user()->promoter;

        $query = Renewal::whereHas('property', function ($q) use ($promoter) {
            $q->where('promoter_id', $promoter->id);
        })
        ->with(['user', 'property', 'booking'])
        ->orderBy('created_at', 'desc');

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $renewals = $query->paginate(15);

        // Active bookings eligible for renewal
        $activeBookings = Booking::whereHas('property', function ($q) use ($promoter) {
            $q->where('promoter_id', $promoter->id);
        })
        ->whereIn('status', ['confirmed', 'active'])
        ->with('property')
        ->get();

        // Upcoming expirations (30 days)
        $upcomingExpirations = Booking::whereHas('property', function ($q) use ($promoter) {
            $q->where('promoter_id', $promoter->id);
        })
        ->whereIn('status', ['confirmed', 'active'])
        ->whereBetween('end_date', [now(), now()->addDays(30)])
        ->with(['property', 'user'])
        ->get();

        return view('livewire.promoter.renewals.renewal-management', [
            'renewals' => $renewals,
            'activeBookings' => $activeBookings,
            'upcomingExpirations' => $upcomingExpirations,
        ])->layout('layouts.app');
    }

    public function approveRenewal($renewalId)
    {
        $promoter = Auth::user()->promoter;
        
        $renewal = Renewal::whereHas('property', function ($q) use ($promoter) {
            $q->where('promoter_id', $promoter->id);
        })->findOrFail($renewalId);

        if ($renewal->status === 'pending') {
            $renewalService = app(RenewalService::class);
            $renewalService->approve($renewal, Auth::id());
            
            session()->flash('success', __('messages.promoter.renewal_approved'));
        }
    }

    public function openRejectModal($renewalId)
    {
        $this->renewalToReject = $renewalId;
        $this->showRejectModal = true;
        $this->rejectionReason = '';
    }

    public function closeRejectModal()
    {
        $this->showRejectModal = false;
        $this->renewalToReject = null;
        $this->rejectionReason = '';
    }

    public function rejectRenewal()
    {
        $this->validate($this->rejectRules);

        $promoter = Auth::user()->promoter;
        
        $renewal = Renewal::whereHas('property', function ($q) use ($promoter) {
            $q->where('promoter_id', $promoter->id);
        })->findOrFail($this->renewalToReject);

        if ($renewal->status === 'pending') {
            $renewalService = app(RenewalService::class);
            $renewalService->reject($renewal, Auth::id(), $this->rejectionReason);
            
            session()->flash('success', __('messages.promoter.renewal_rejected'));
        }

        $this->closeRejectModal();
    }

    public function toggleInitiateForm()
    {
        $this->showInitiateForm = !$this->showInitiateForm;
        $this->reset(['selectedBookingId', 'newEndDate', 'renewalDuration', 'renewalFrequency', 'renewalAmount', 'notes']);
    }

    public function initiateRenewal()
    {
        $this->validate();

        $renewalService = app(RenewalService::class);
        
        $booking = Booking::findOrFail($this->selectedBookingId);
        
        $renewalData = [
            'new_end_date' => $this->newEndDate,
            'renewal_duration' => $this->renewalDuration,
            'renewal_frequency' => $this->renewalFrequency,
            'renewal_amount' => $this->renewalAmount,
            'notes' => $this->notes,
            'renewal_type' => 'promoter_initiated',
        ];

        $renewal = $renewalService->createRenewal($booking->id, $booking->user_id, $renewalData);
        
        // Auto-approve since it's initiated by promoter
        $renewalService->approve($renewal, Auth::id());
        
        session()->flash('success', __('messages.promoter.renewal_initiated'));
        $this->toggleInitiateForm();
    }

    public function sendReminder($bookingId)
    {
        $promoter = Auth::user()->promoter;
        
        $booking = Booking::whereHas('property', function ($q) use ($promoter) {
            $q->where('promoter_id', $promoter->id);
        })->findOrFail($bookingId);

        // TODO: Send renewal reminder notification to client
        
        session()->flash('success', __('messages.promoter.reminder_sent'));
    }
}


