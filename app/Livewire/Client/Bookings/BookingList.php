<?php

namespace App\Livewire\Client\Bookings;

use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;

class BookingList extends Component
{
    use WithPagination;

    public $statusFilter = 'all';

    public function render()
    {
        $query = Booking::where('user_id', auth()->id())
            ->with(['property', 'payments'])
            ->orderBy('created_at', 'desc');

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $bookings = $query->paginate(10);

        return view('livewire.client.bookings.booking-list', [
            'bookings' => $bookings,
        ])->layout('layouts.app');
    }

    public function cancelBooking($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->first();

        if ($booking && $booking->status === 'pending') {
            $booking->update(['status' => 'cancelled']);
            session()->flash('success', __('messages.booking.cancelled_success'));
        }
    }
}

