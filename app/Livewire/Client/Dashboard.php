<?php

namespace App\Livewire\Client;

use App\Models\Reservation;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $stats = [];
    public $recentBookings = [];
    public $pendingPayments = [];

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $userId = Auth::id();

        // Statistics
        $this->stats = [
            'active_bookings' => Reservation::where('client_id', $userId)
                ->where('statut', 'CONFIRME')
                ->whereDate('date_fin', '>=', now())
                ->count(),
            'total_bookings' => Reservation::where('client_id', $userId)->count(),
            'pending_payments' => Paiement::whereHas('reservation', function($query) use ($userId) {
                    $query->where('client_id', $userId);
                })
                ->where('statut', 'EN_ATTENTE')
                ->count(),
            'pending_reservations' => Reservation::where('client_id', $userId)
                ->where('statut', 'EN_ATTENTE')
                ->count(),
        ];

        // Recent Bookings
        $this->recentBookings = Reservation::where('client_id', $userId)
            ->with('bien')
            ->latest('date_reservation')
            ->take(5)
            ->get();

        // Pending Payments
        $this->pendingPayments = Paiement::whereHas('reservation', function($query) use ($userId) {
                $query->where('client_id', $userId);
            })
            ->whereIn('statut', ['EN_ATTENTE', 'EN_COURS'])
            ->with('reservation.bien')
            ->latest('date_paiement')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.client.dashboard')->layout('layouts.app');
    }
}
