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
    public $bedrooms = '';
    public $bathrooms = '';
    public $minArea = '';
    public $maxArea = '';
    public $location = '';
    public $availabilityStatus = '';
    public $sortBy = 'latest'; // latest, price_asc, price_desc, area_asc, area_desc

    protected $queryString = [
        'search' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'location' => ['except' => ''],
        'sortBy' => ['except' => 'latest'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingLocation()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'typeFilter', 'minPrice', 'maxPrice', 'bedrooms', 'bathrooms', 'minArea', 'maxArea', 'location', 'availabilityStatus', 'sortBy']);
        $this->resetPage();
    }

    public function render()
    {
        $properties = Property::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title_fr', 'like', '%' . $this->search . '%')
                      ->orWhere('title_en', 'like', '%' . $this->search . '%')
                      ->orWhere('location', 'like', '%' . $this->search . '%')
                      ->orWhere('address', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->when($this->location, function ($query) {
                $query->where('location', 'like', '%' . $this->location . '%');
            })
            ->when($this->minPrice, function ($query) {
                $query->where('price', '>=', $this->minPrice);
            })
            ->when($this->maxPrice, function ($query) {
                $query->where('price', '<=', $this->maxPrice);
            })
            ->when($this->bedrooms, function ($query) {
                $query->where('bedrooms', '>=', $this->bedrooms);
            })
            ->when($this->bathrooms, function ($query) {
                $query->where('bathrooms', '>=', $this->bathrooms);
            })
            ->when($this->minArea, function ($query) {
                $query->where('area', '>=', $this->minArea);
            })
            ->when($this->maxArea, function ($query) {
                $query->where('area', '<=', $this->maxArea);
            })
            ->when($this->availabilityStatus, function ($query) {
                $query->where('availability_status', $this->availabilityStatus);
            })
            ->when(!$this->availabilityStatus, function ($query) {
                $query->available();
            });

        // Apply sorting
        switch ($this->sortBy) {
            case 'price_asc':
                $properties->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $properties->orderBy('price', 'desc');
                break;
            case 'area_asc':
                $properties->orderBy('area', 'asc');
                break;
            case 'area_desc':
                $properties->orderBy('area', 'desc');
                break;
            case 'latest':
            default:
                $properties->latest();
                break;
        }

        $properties = $properties->paginate(12);

        return view('livewire.properties.index', [
            'properties' => $properties
        ])->layout('layouts.app');
    }
}
