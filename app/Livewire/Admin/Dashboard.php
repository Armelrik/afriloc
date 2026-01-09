<?php

namespace App\Livewire\Admin;

use App\Models\Bien;
use App\Models\Reservation;
use App\Models\Paiement;
use App\Models\Promoteur;
use App\Models\User;
use App\Models\DemandeValidation;
use App\Models\Commission;
use App\Models\Client;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // Main statistics
        $stats = [
            'properties' => Bien::count(),
            'bookings' => Reservation::count(),
            'available_properties' => Bien::disponible()->count(),
            'total_revenue' => Paiement::where('statut', 'VALIDE')->sum('montant') ?? 0,
            'revenue' => Paiement::where('statut', 'VALIDE')->sum('montant') ?? 0, // Alias pour compatibilité
            'pending_payments' => Paiement::where('statut', 'EN_ATTENTE')->count(),
            'pending_promoters' => Promoteur::where('statut', 'EN_ATTENTE')->count(),
            'total_users' => User::count(),
            'active_bookings' => Reservation::whereIn('statut', ['CONFIRME'])->count(),
            'promoters' => Promoteur::where('statut', 'VALIDE')->count(),
            // Nouvelles statistiques
            'pending_validations' => DemandeValidation::where('statut', 'EN_ATTENTE')->count(),
            'pending_commissions' => Commission::where('est_transfere', false)->count(),
            'pending_commissions_amount' => Commission::where('est_transfere', false)->sum('montant_commission') ?? 0,
            'total_clients' => Client::count(),
            'active_clients' => Client::whereHas('user', function ($q) {
                $q->where('est_actif', true);
            })->count(),
            'unread_notifications' => Notification::where('est_lue', false)->count(),
        ];

        // Calculate trends (last 30 days vs previous 30 days)
        $trends = [
            'bookings' => $this->calculateTrend(Reservation::class),
            'revenue' => $this->calculateRevenueTrend(),
            'properties' => $this->calculateTrend(Bien::class),
        ];

        // Recent activities
        $recentBookings = Reservation::with(['client', 'bien'])->latest()->take(5)->get();
        $recentPayments = Paiement::with(['reservation.bien'])->where('statut', 'VALIDE')->latest()->take(5)->get();
        $pendingPromoters = Promoteur::with('user')->enAttente()->latest()->take(5)->get();
        $recentValidations = DemandeValidation::with(['promoteur.user'])->latest('date_demande')->take(5)->get();
        $recentCommissions = Commission::with(['promoteur.user', 'paiement'])->latest('date_calcul')->take(5)->get();

        // Monthly data for charts (last 6 months)
        $monthlyBookings = $this->getMonthlyData(Reservation::class);
        $monthlyRevenue = $this->getMonthlyRevenue();
        
        // Format monthly data for charts
        $monthlyData = [
            'labels' => array_column($monthlyRevenue, 'month'),
        ];
        
        // Booking stats for pie chart
        $bookingStats = [
            'confirmed' => Reservation::where('statut', 'CONFIRME')->count(),
            'pending' => Reservation::where('statut', 'EN_ATTENTE')->count(),
            'cancelled' => Reservation::where('statut', 'ANNULE')->count(),
        ];
        
        // Recent properties
        $recentProperties = Bien::latest()->take(5)->get();

        // Top properties
        $topProperties = Bien::withCount('reservations')
            ->orderBy('reservations_count', 'desc')
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', compact(
            'stats', 
            'trends', 
            'recentBookings', 
            'recentPayments', 
            'pendingPromoters',
            'monthlyBookings',
            'monthlyRevenue',
            'monthlyData',
            'bookingStats',
            'recentProperties',
            'topProperties',
            'recentValidations',
            'recentCommissions'
        ))->layout('layouts.admin');
    }

    private function calculateTrend($model)
    {
        $current = $model::where('created_at', '>=', now()->subDays(30))->count();
        $previous = $model::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();
        
        if ($previous == 0) return 0;
        
        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function calculateRevenueTrend()
    {
        $current = Paiement::where('statut', 'VALIDE')
            ->where('date_paiement', '>=', now()->subDays(30))
            ->sum('montant');
        $previous = Paiement::where('statut', 'VALIDE')
            ->whereBetween('date_paiement', [now()->subDays(60), now()->subDays(30)])
            ->sum('montant');
        
        if ($previous == 0) return 0;
        
        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function getMonthlyData($model)
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = $model::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $data[] = [
                'month' => $date->format('M'),
                'count' => $count
            ];
        }
        return $data;
    }

    private function getMonthlyRevenue()
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenue = Paiement::where('statut', 'VALIDE')
                ->whereYear('date_paiement', $date->year)
                ->whereMonth('date_paiement', $date->month)
                ->sum('montant');
            $data[] = [
                'month' => $date->format('M'),
                'amount' => $revenue
            ];
        }
        return $data;
    }
}

