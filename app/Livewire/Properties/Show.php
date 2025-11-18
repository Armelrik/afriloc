<?php

namespace App\Livewire\Properties;

use App\Models\Property;
use Livewire\Component;

class Show extends Component
{
    public Property $property;

    public function mount($id)
    {
        $this->property = Property::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.properties.show')->layout('layouts.app');
    }
}
