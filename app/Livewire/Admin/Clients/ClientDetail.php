<?php

namespace App\Livewire\Admin\Clients;

use App\Models\Client;
use Livewire\Component;

class ClientDetail extends Component
{
    public $client;

    public function mount($id)
    {
        $this->client = Client::with([
            'user',
            'reservations.bien',
            'reservations.paiement'
        ])->findOrFail($id);
    }

    public function suspendre()
    {
        $this->client->user->update(['est_actif' => false]);
        session()->flash('success', 'Client suspendu avec succès.');
        $this->client->refresh();
    }

    public function reactiver()
    {
        $this->client->user->update(['est_actif' => true]);
        session()->flash('success', 'Client réactivé avec succès.');
        $this->client->refresh();
    }

    public function render()
    {
        $reservations = $this->client->reservations()->with(['bien', 'paiement'])->latest()->get();
        $totalDepense = $this->client->reservations()
            ->whereHas('paiement', function ($q) {
                $q->where('statut', 'VALIDE');
            })
            ->with('paiement')
            ->get()
            ->sum(function ($reservation) {
                return $reservation->paiement && $reservation->paiement->statut === 'VALIDE' 
                    ? $reservation->paiement->montant 
                    : 0;
            });

        return view('livewire.admin.clients.client-detail', [
            'reservations' => $reservations,
            'totalDepense' => $totalDepense,
        ])->layout('layouts.admin');
    }
}

