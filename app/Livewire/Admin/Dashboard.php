<?php

namespace App\Livewire\Admin;

use App\Models\Property;
use App\Models\Booking;
use App\Models\Contact;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'properties' => Property::count(),
            'bookings' => Booking::count(),
            'contacts' => Contact::count(),
            'available_properties' => Property::available()->count(),
        ];

        return view('livewire.admin.dashboard', compact('stats'))->layout('layouts.app');
    }
}

