<?php

namespace App\Livewire\Client\Maintenance;

use App\Models\Booking;
use App\Models\MaintenanceRequest;
use Livewire\Component;
use Livewire\WithPagination;

class MaintenanceRequests extends Component
{
    use WithPagination;

    public $showCreateForm = false;
    public $title = '';
    public $description = '';
    public $priority = 'normal';
    public $booking_id = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'priority' => 'required|in:low,normal,high,urgent',
        'booking_id' => 'required|exists:bookings,id',
    ];

    public function mount()
    {
        // If route is for create, show the form
        if (request()->routeIs('client.maintenance.create')) {
            $this->showCreateForm = true;
        }
    }

    public function render()
    {
        $maintenanceRequests = MaintenanceRequest::whereHas('booking', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->with(['booking.property', 'booking.user'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $activeBookings = Booking::where('user_id', auth()->id())
            ->whereIn('status', ['confirmed', 'active'])
            ->with('property')
            ->get();

        return view('livewire.client.maintenance.maintenance-requests', [
            'maintenanceRequests' => $maintenanceRequests,
            'activeBookings' => $activeBookings,
        ])->layout('layouts.app');
    }

    public function submitRequest()
    {
        $this->validate();

        MaintenanceRequest::create([
            'booking_id' => $this->booking_id,
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'status' => 'pending',
        ]);

        session()->flash('success', __('messages.maintenance.request_submitted'));
        
        $this->reset(['title', 'description', 'priority', 'booking_id']);
        $this->showCreateForm = false;

        return redirect()->route('client.maintenance.index');
    }

    public function toggleCreateForm()
    {
        $this->showCreateForm = !$this->showCreateForm;
        $this->reset(['title', 'description', 'priority', 'booking_id']);
    }
}

