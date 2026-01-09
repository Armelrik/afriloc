<?php

namespace App\Livewire\Admin\Properties;

use App\Models\Bien;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyList extends Component
{
    use WithPagination;

    public function delete($id)
    {
        Bien::findOrFail($id)->delete();
        session()->flash('message', 'Property deleted successfully.');
    }

    public function deleteProperty($id)
    {
        $this->delete($id);
    }

    public function render()
    {
        $properties = Bien::latest()->paginate(10);
        return view('livewire.admin.properties.property-list', compact('properties'))->layout('layouts.admin');
    }
}

