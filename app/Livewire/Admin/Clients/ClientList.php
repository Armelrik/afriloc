<?php

namespace App\Livewire\Admin\Clients;

use App\Models\Client;
use App\Models\Reservation;
use App\Models\Paiement;
use Livewire\Component;
use Livewire\WithPagination;

class ClientList extends Component
{
    use WithPagination;

    public $filterVille = '';
    public $filterActif = '';
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterVille()
    {
        $this->resetPage();
    }

    public function updatingFilterActif()
    {
        $this->resetPage();
    }

    public function suspendre($id)
    {
        $client = Client::findOrFail($id);
        $client->user->update(['est_actif' => false]);
        
        session()->flash('success', 'Client suspendu avec succès.');
    }

    public function reactiver($id)
    {
        $client = Client::findOrFail($id);
        $client->user->update(['est_actif' => true]);
        
        session()->flash('success', 'Client réactivé avec succès.');
    }

    public function viewDetails($id)
    {
        return redirect()->route('admin.clients.show', $id);
    }

    public function render()
    {
        $clients = Client::with(['user', 'reservations'])
            ->when($this->filterVille, function ($query) {
                $query->where('ville_residence', $this->filterVille);
            })
            ->when($this->filterActif !== '', function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('est_actif', $this->filterActif === '1');
                });
            })
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('nom', 'like', '%' . $this->search . '%')
                        ->orWhere('prenom', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('telephone', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(15);

        // Statistiques
        $totalClients = Client::count();
        $clientsActifs = Client::whereHas('user', function ($q) {
            $q->where('est_actif', true);
        })->count();
        $totalReservations = Reservation::count();
        $totalDepense = Paiement::where('statut', 'VALIDE')
            ->whereHas('reservation', function ($q) {
                $q->whereIn('client_id', Client::pluck('user_id'));
            })
            ->sum('montant');

        $villes = Client::distinct()->pluck('ville_residence')->filter();

        return view('livewire.admin.clients.client-list', [
            'clients' => $clients,
            'totalClients' => $totalClients,
            'clientsActifs' => $clientsActifs,
            'totalReservations' => $totalReservations,
            'totalDepense' => $totalDepense,
            'villes' => $villes,
        ])->layout('layouts.admin');
    }
}

