<?php

namespace App\Livewire\Properties;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $typeFilter = '';
    public $minPrice = '';
    public $maxPrice = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $properties = Property::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title_fr', 'like', '%' . $this->search . '%')
                      ->orWhere('title_en', 'like', '%' . $this->search . '%')
                      ->orWhere('location', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->when($this->minPrice, function ($query) {
                $query->where('price', '>=', $this->minPrice);
            })
            ->when($this->maxPrice, function ($query) {
                $query->where('price', '<=', $this->maxPrice);
            })
            ->available()
            ->latest()
            ->paginate(12);

        return view('livewire.properties.index', [
            'properties' => $properties
        ])->layout('layouts.app');
    }
}
