<?php

namespace App\Livewire\Admin\Bookings;

use App\Models\Reservation;
use Livewire\Component;
use Livewire\WithPagination;

class BookingList extends Component
{
    use WithPagination;

    public function updateStatus($id, $status)
    {
        $booking = Reservation::findOrFail($id);
        $booking->update(['statut' => $status]);
        
        // Mettre à jour la disponibilité du bien en fonction du statut
        if ($booking->bien) {
            if ($status === 'CONFIRME') {
                $booking->bien->update(['disponibilite' => 'loue']);
            } elseif ($status === 'ANNULE') {
                $booking->bien->update(['disponibilite' => 'disponible']);
            }
        }

        session()->flash('message', 'Booking status updated successfully.');
    }

    public function render()
    {
        $bookings = Reservation::with('bien')->latest()->paginate(10);
        return view('livewire.admin.bookings.booking-list', compact('bookings'))->layout('layouts.admin');
    }
}

