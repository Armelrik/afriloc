<?php

namespace App\Livewire\Properties;

use App\Models\Bien;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public Bien $property;
    public $existingReservation = null;

    public function mount($id)
    {
        $this->property = Bien::with(['medias', 'promoteur.user'])
            ->publie()
            ->findOrFail($id);
            
        // Check if user has an existing reservation for this property
        if (Auth::check()) {
            $this->existingReservation = Reservation::where('client_id', Auth::id())
                ->where('bien_id', $id)
                ->whereIn('statut', ['EN_ATTENTE', 'CONFIRME', 'TERMINE'])
                ->first();
        }
    }

    public function render()
    {
        return view('livewire.properties.show')->layout('layouts.app');
    }
}
