<?php

namespace App\Livewire\Promoter\Properties;

use App\Models\Bien;
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
        $property = Bien::where('promoteur_id', Auth::user()->promoteur->id)->findOrFail($id);
        $property->delete();
        
        session()->flash('success', __('messages.properties.deleted'));
    }

    public function render()
    {
        $properties = Bien::where('promoteur_id', Auth::user()->promoteur->id)
            ->when($this->search, function ($query) {
                $query->where('titre', 'like', '%' . $this->search . '%')
                      ->orWhere('ville', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('disponibilite', $this->filterStatus);
            })
            ->latest('date_ajout')
            ->paginate(10);

        return view('livewire.promoter.properties.property-manager', [
            'properties' => $properties,
        ])->layout('layouts.app');
    }
}
