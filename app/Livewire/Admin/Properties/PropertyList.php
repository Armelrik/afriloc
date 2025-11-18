<?php

namespace App\Livewire\Admin\Properties;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyList extends Component
{
    use WithPagination;

    public function delete($id)
    {
        Property::findOrFail($id)->delete();
        session()->flash('message', 'Property deleted successfully.');
    }

    public function render()
    {
        $properties = Property::latest()->paginate(10);
        return view('livewire.admin.properties.property-list', compact('properties'))->layout('layouts.app');
    }
}

