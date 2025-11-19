<?php

namespace App\Livewire\Client;

use App\Models\Booking;
use App\Models\MaintenanceRequest;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Renewal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $stats = [];
    public $recentBookings = [];
    public $upcomingRenewals = [];
    public $pendingPayments = [];
    public $recentMaintenanceRequests = [];
    public $unreadMessages = 0;

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $userId = Auth::id();

        // Statistics
        $this->stats = [
            'active_bookings' => Booking::where('user_id', $userId)
                ->where('status', 'confirmed')
                ->whereDate('end_date', '>=', now())
                ->count(),
            'total_bookings' => Booking::where('user_id', $userId)->count(),
            'pending_payments' => Payment::where('user_id', $userId)
                ->where('status', 'pending')
                ->count(),
            'maintenance_requests' => MaintenanceRequest::where('user_id', $userId)
                ->whereIn('status', ['pending', 'in_progress'])
                ->count(),
            'unread_messages' => Message::receivedBy($userId)->unread()->count(),
            'upcoming_renewals' => Renewal::where('user_id', $userId)
                ->where('status', 'pending')
                ->count(),
        ];

        // Recent Bookings
        $this->recentBookings = Booking::where('user_id', $userId)
            ->with('property')
            ->latest()
            ->take(5)
            ->get();

        // Upcoming Renewals
        $this->upcomingRenewals = Renewal::where('user_id', $userId)
            ->where('status', 'pending')
            ->with('property', 'booking')
            ->orderBy('current_end_date', 'asc')
            ->take(3)
            ->get();

        // Pending Payments
        $this->pendingPayments = Payment::where('user_id', $userId)
            ->whereIn('status', ['pending', 'processing'])
            ->with('booking.property')
            ->latest()
            ->take(3)
            ->get();

        // Recent Maintenance Requests
        $this->recentMaintenanceRequests = MaintenanceRequest::where('user_id', $userId)
            ->with('property')
            ->latest()
            ->take(5)
            ->get();

        // Unread Messages Count
        $this->unreadMessages = $this->stats['unread_messages'];
    }

    public function render()
    {
        return view('livewire.client.dashboard')->layout('layouts.app');
    }
}
