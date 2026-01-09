<?php

namespace App\Livewire\Admin\Bookings;

use App\Models\Reservation;
use Livewire\Component;

class BookingDetail extends Component
{
    public $booking;
    public $showCancelModal = false;
    public $showDeleteModal = false;

    public function mount($id)
    {
        $this->booking = Reservation::with([
            'client',
            'bien.promoteur.user',
            'paiement',
            'paiement.paiementMobileMoney',
            'paiement.paiementCarte'
        ])->findOrFail($id);
    }

    public function openCancelModal()
    {
        $this->showCancelModal = true;
    }

    public function openDeleteModal()
    {
        $this->showDeleteModal = true;
    }

    public function confirm()
    {
        $this->booking->confirmer();
        session()->flash('success', 'Réservation confirmée avec succès.');
        $this->booking->refresh();
    }

    public function cancel()
    {
        $this->booking->annuler();
        session()->flash('success', 'Réservation annulée avec succès.');
        $this->closeModals();
        $this->booking->refresh();
    }

    public function delete()
    {
        $this->booking->delete();
        session()->flash('success', 'Réservation supprimée avec succès.');
        return redirect()->route('admin.bookings');
    }

    public function closeModals()
    {
        $this->showCancelModal = false;
        $this->showDeleteModal = false;
    }

    public function render()
    {
        $duree = $this->booking->getDureeEnJours();
        
        return view('livewire.admin.bookings.booking-detail', [
            'duree' => $duree,
        ])->layout('layouts.admin');
    }
}

