<?php

namespace App\Livewire\Promoter;

use App\Models\Bien;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $promoter = Auth::user()->promoteur;
        $userId = Auth::id();
        
        $stats = [
            'total_properties' => Bien::where('promoteur_id', $promoter->id)->count(),
            'active_bookings' => Reservation::whereHas('bien', function ($query) use ($promoter) {
                $query->where('promoteur_id', $promoter->id);
            })->where('statut', 'CONFIRMEE')->count(),
            'total_earnings' => Reservation::whereHas('bien', function ($query) use ($promoter) {
                $query->where('promoteur_id', $promoter->id);
            })->where('statut', 'CONFIRMEE')->sum('montant_total'),
            'pending_bookings' => Reservation::whereHas('bien', function ($query) use ($promoter) {
                $query->where('promoteur_id', $promoter->id);
            })->where('statut', 'EN_ATTENTE')->count(),
            'pending_renewals' => 0,
            'pending_maintenance' => 0,
            'unread_messages' => 0,
        ];
        
        $recentBookings = Reservation::whereHas('bien', function ($query) use ($promoter) {
            $query->where('promoteur_id', $promoter->id);
        })->with(['client.user', 'bien'])->latest()->take(5)->get();
        
        $pendingRenewals = collect();
        $recentMaintenance = collect();
        
        return view('livewire.promoter.dashboard', [
            'stats' => $stats,
            'recentBookings' => $recentBookings,
            'pendingRenewals' => $pendingRenewals,
            'recentMaintenance' => $recentMaintenance,
            'promoter' => $promoter,
        ])->layout('layouts.app');
    }
}
