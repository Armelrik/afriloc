<?php

namespace App\Livewire\Client\Bookings;

use App\Models\Reservation;
use Livewire\Component;
use Livewire\WithPagination;

class BookingList extends Component
{
    use WithPagination;

    public $statusFilter = 'all';

    public function render()
    {
        $query = Reservation::where('client_id', auth()->id())
            ->with(['bien', 'paiement'])
            ->orderBy('date_reservation', 'desc');

        if ($this->statusFilter !== 'all') {
            // Map filter values to database statuses
            $statusMap = [
                'pending' => 'EN_ATTENTE',
                'confirmed' => 'CONFIRME',
                'active' => 'CONFIRME',
                'completed' => 'TERMINE',
            ];
            
            if (isset($statusMap[$this->statusFilter])) {
                $query->where('statut', $statusMap[$this->statusFilter]);
            }
        }

        $bookings = $query->paginate(10);

        return view('livewire.client.bookings.booking-list', [
            'bookings' => $bookings,
        ])->layout('layouts.app');
    }

    public function cancelBooking($bookingId)
    {
        $booking = Reservation::where('id', $bookingId)
            ->where('client_id', auth()->id())
            ->first();

        if ($booking && $booking->statut === 'EN_ATTENTE') {
            $booking->update(['statut' => 'ANNULE']);
            session()->flash('success', 'Réservation annulée avec succès');
        }
    }
}

