<?php

namespace App\Livewire\Components;

use App\Models\Bien;
use Livewire\Component;

class PropertyCard extends Component
{
    public Bien $property;

    public function mount(Bien $property)
    {
        $this->property = $property;
    }

    public function render()
    {
        return view('livewire.components.property-card');
    }
}
