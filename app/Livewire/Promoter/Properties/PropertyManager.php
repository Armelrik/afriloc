<?php

namespace App\Livewire\Promoter\Properties;

use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyManager extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';

    public function deleteProperty($id)
    {
        $property = Property::where('promoter_id', Auth::user()->promoter->id)->findOrFail($id);
        $property->delete();
        
        session()->flash('success', __('Property deleted successfully'));
    }

    public function render()
    {
        $properties = Property::byPromoter(Auth::user()->promoter->id)
            ->when($this->search, function ($query) {
                $query->where('title_fr', 'like', '%' . $this->search . '%')
                      ->orWhere('title_en', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('availability_status', $this->filterStatus);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.promoter.properties.property-manager', [
            'properties' => $properties,
        ])->layout('layouts.app');
    }
}
