<?php

namespace App\Livewire\Properties;

use App\Models\Bien;
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
        $properties = Bien::query()
            ->publie()
            ->with(['medias', 'promoteur'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('titre', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhere('ville', 'like', '%' . $this->search . '%')
                      ->orWhere('adresse', 'like', '%' . $this->search . '%')
                      ->orWhere('quartier', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('type_bien', $this->typeFilter);
            })
            ->when($this->location, function ($query) {
                $query->where('ville', 'like', '%' . $this->location . '%');
            })
            ->when($this->minPrice, function ($query) {
                $query->where('prix_location', '>=', $this->minPrice);
            })
            ->when($this->maxPrice, function ($query) {
                $query->where('prix_location', '<=', $this->maxPrice);
            })
            ->when($this->bedrooms, function ($query) {
                $query->where('nombre_chambres', '>=', $this->bedrooms);
            })
            ->when($this->bathrooms, function ($query) {
                $query->where('nombre_salles_bain', '>=', $this->bathrooms);
            })
            ->when($this->minArea, function ($query) {
                $query->where('superficie', '>=', $this->minArea);
            })
            ->when($this->maxArea, function ($query) {
                $query->where('superficie', '<=', $this->maxArea);
            })
            ->when($this->availabilityStatus, function ($query) {
                $query->where('disponibilite', $this->availabilityStatus);
            })
            ->when(!$this->availabilityStatus, function ($query) {
                $query->disponible();
            });

        // Apply sorting
        switch ($this->sortBy) {
            case 'price_asc':
                $properties->orderBy('prix_location', 'asc');
                break;
            case 'price_desc':
                $properties->orderBy('prix_location', 'desc');
                break;
            case 'area_asc':
                $properties->orderBy('superficie', 'asc');
                break;
            case 'area_desc':
                $properties->orderBy('superficie', 'desc');
                break;
            case 'latest':
            default:
                $properties->latest('date_ajout');
                break;
        }

        $properties = $properties->paginate(12);

        return view('livewire.properties.index', [
            'properties' => $properties
        ])->layout('layouts.app');
    }
}
