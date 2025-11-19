<?php

namespace App\Livewire\Promoter\Bookings;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BookingManagement extends Component
{
    use WithPagination;

    public $statusFilter = 'all';
    public $selectedBooking = null;
    public $showDetails = false;
    public $showRejectModal = false;
    public $rejectionReason = '';
    public $bookingToReject = null;

    protected $rules = [
        'rejectionReason' => 'required|string|min:10',
    ];

    public function render()
    {
        $promoter = Auth::user()->promoter;

        $query = Booking::whereHas('property', function ($q) use ($promoter) {
            $q->where('promoter_id', $promoter->id);
        })
        ->with(['property', 'user', 'payments'])
        ->orderBy('created_at', 'desc');

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $bookings = $query->paginate(15);

        return view('livewire.promoter.bookings.booking-management', [
            'bookings' => $bookings,
        ])->layout('layouts.app');
    }

    public function confirmBooking($bookingId)
    {
        $promoter = Auth::user()->promoter;
        
        $booking = Booking::whereHas('property', function ($q) use ($promoter) {
            $q->where('promoter_id', $promoter->id);
        })->findOrFail($bookingId);

        if ($booking->status === 'pending') {
            $booking->update(['status' => 'confirmed']);
            
            // TODO: Envoyer notification au client
            
            session()->flash('success', __('messages.promoter.booking_confirmed'));
        }
    }

    public function openRejectModal($bookingId)
    {
        $this->bookingToReject = $bookingId;
        $this->showRejectModal = true;
        $this->rejectionReason = '';
    }

    public function closeRejectModal()
    {
        $this->showRejectModal = false;
        $this->bookingToReject = null;
        $this->rejectionReason = '';
    }

    public function rejectBooking()
    {
        $this->validate();

        $promoter = Auth::user()->promoter;
        
        $booking = Booking::whereHas('property', function ($q) use ($promoter) {
            $q->where('promoter_id', $promoter->id);
        })->findOrFail($this->bookingToReject);

        if ($booking->status === 'pending') {
            $booking->update([
                'status' => 'cancelled',
                'comments' => 'Rejeté par le promoteur: ' . $this->rejectionReason,
            ]);
            
            // TODO: Envoyer notification au client
            
            session()->flash('success', __('messages.promoter.booking_rejected'));
        }

        $this->closeRejectModal();
    }

    public function viewDetails($bookingId)
    {
        $promoter = Auth::user()->promoter;
        
        $this->selectedBooking = Booking::whereHas('property', function ($q) use ($promoter) {
            $q->where('promoter_id', $promoter->id);
        })
        ->with(['property', 'user', 'payments'])
        ->findOrFail($bookingId);
        
        $this->showDetails = true;
    }

    public function closeDetails()
    {
        $this->showDetails = false;
        $this->selectedBooking = null;
    }
}


