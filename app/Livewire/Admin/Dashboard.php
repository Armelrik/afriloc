<?php

namespace App\Livewire\Admin;

use App\Models\Property;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Payment;
use App\Models\Renewal;
use App\Models\MaintenanceRequest;
use App\Models\Promoter;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // Main statistics
        $stats = [
            'properties' => Property::count(),
            'bookings' => Booking::count(),
            'contacts' => Contact::count(),
            'available_properties' => Property::available()->count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount') ?? 0,
            'revenue' => Payment::where('status', 'completed')->sum('amount') ?? 0, // Alias pour compatibilité
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'pending_renewals' => Renewal::where('status', 'pending')->count(),
            'pending_maintenance' => MaintenanceRequest::where('status', 'pending')->count(),
            'pending_promoters' => Promoter::where('status', 'pending')->count(),
            'total_users' => User::count(),
            'active_bookings' => Booking::whereIn('status', ['confirmed', 'active'])->count(),
            'urgent_maintenance' => MaintenanceRequest::where('priority', 'urgent')
                ->whereIn('status', ['pending', 'in_progress'])->count(),
            'promoters' => Promoter::where('status', 'approved')->count(),
            'pending_contacts' => Contact::count(), // Tous les contacts (le modèle n'a pas de champ status)
        ];

        // Calculate trends (last 30 days vs previous 30 days)
        $trends = [
            'bookings' => $this->calculateTrend(Booking::class),
            'revenue' => $this->calculateRevenueTrend(),
            'properties' => $this->calculateTrend(Property::class),
        ];

        // Recent activities
        $recentBookings = Booking::with(['user', 'property'])->latest()->take(5)->get();
        $recentPayments = Payment::with(['user', 'booking.property'])->completed()->latest()->take(5)->get();
        $urgentMaintenance = MaintenanceRequest::with(['user', 'property'])->urgent()->latest()->take(5)->get();
        $pendingPromoters = Promoter::with('user')->pending()->latest()->take(5)->get();

        // Monthly data for charts (last 6 months)
        $monthlyBookings = $this->getMonthlyData(Booking::class);
        $monthlyRevenue = $this->getMonthlyRevenue();
        
        // Format monthly data for charts
        $monthlyData = [
            'labels' => array_column($monthlyRevenue, 'month'),
        ];
        
        // Booking stats for pie chart
        $bookingStats = [
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];
        
        // Recent properties
        $recentProperties = Property::latest()->take(5)->get();

        // Top properties
        $topProperties = Property::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', compact(
            'stats', 
            'trends', 
            'recentBookings', 
            'recentPayments', 
            'urgentMaintenance',
            'pendingPromoters',
            'monthlyBookings',
            'monthlyRevenue',
            'monthlyData',
            'bookingStats',
            'recentProperties',
            'topProperties'
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
        $current = Payment::completed()
            ->where('paid_at', '>=', now()->subDays(30))
            ->sum('amount');
        $previous = Payment::completed()
            ->whereBetween('paid_at', [now()->subDays(60), now()->subDays(30)])
            ->sum('amount');
        
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
            $revenue = Payment::completed()
                ->whereYear('paid_at', $date->year)
                ->whereMonth('paid_at', $date->month)
                ->sum('amount');
            $data[] = [
                'month' => $date->format('M'),
                'amount' => $revenue
            ];
        }
        return $data;
    }
}

