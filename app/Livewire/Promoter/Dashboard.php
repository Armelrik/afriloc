<?php

namespace App\Livewire\Promoter;

use App\Models\Booking;
use App\Models\Property;
use App\Models\Renewal;
use App\Models\MaintenanceRequest;
use App\Models\Message;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $promoter = Auth::user()->promoter;
        $userId = Auth::id();
        
        $stats = [
            'total_properties' => Property::byPromoter($promoter->id)->count(),
            'active_bookings' => Booking::whereHas('property', function ($query) use ($promoter) {
                $query->where('promoter_id', $promoter->id);
            })->where('status', 'confirmed')->count(),
            'total_earnings' => Booking::whereHas('property', function ($query) use ($promoter) {
                $query->where('promoter_id', $promoter->id);
            })->where('payment_status', 'completed')->sum('promoter_amount'),
            'pending_bookings' => Booking::whereHas('property', function ($query) use ($promoter) {
                $query->where('promoter_id', $promoter->id);
            })->where('status', 'pending')->count(),
            'pending_renewals' => Renewal::whereHas('property', function ($query) use ($promoter) {
                $query->where('promoter_id', $promoter->id);
            })->where('status', 'pending')->count(),
            'pending_maintenance' => MaintenanceRequest::whereHas('property', function ($query) use ($promoter) {
                $query->where('promoter_id', $promoter->id);
            })->whereIn('status', ['pending', 'in_progress'])->count(),
            'unread_messages' => Message::receivedBy($userId)->unread()->count(),
        ];
        
        $recentBookings = Booking::whereHas('property', function ($query) use ($promoter) {
            $query->where('promoter_id', $promoter->id);
        })->with(['user', 'property'])->latest()->take(5)->get();
        
        $pendingRenewals = Renewal::whereHas('property', function ($query) use ($promoter) {
            $query->where('promoter_id', $promoter->id);
        })->where('status', 'pending')->with(['user', 'property'])->latest()->take(3)->get();
        
        $recentMaintenance = MaintenanceRequest::whereHas('property', function ($query) use ($promoter) {
            $query->where('promoter_id', $promoter->id);
        })->with(['user', 'property'])->latest()->take(5)->get();
        
        return view('livewire.promoter.dashboard', [
            'stats' => $stats,
            'recentBookings' => $recentBookings,
            'pendingRenewals' => $pendingRenewals,
            'recentMaintenance' => $recentMaintenance,
            'promoter' => $promoter,
        ])->layout('layouts.app');
    }
}
