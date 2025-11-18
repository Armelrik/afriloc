<?php

namespace App\Livewire\Admin\Bookings;

use App\Models\Booking;
use Livewire\Component;
use Livewire\WithPagination;

class BookingList extends Component
{
    use WithPagination;

    public function updateStatus($id, $status)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $status]);
        session()->flash('message', 'Booking status updated successfully.');
    }

    public function render()
    {
        $bookings = Booking::with('property')->latest()->paginate(10);
        return view('livewire.admin.bookings.booking-list', compact('bookings'))->layout('layouts.app');
    }
}

