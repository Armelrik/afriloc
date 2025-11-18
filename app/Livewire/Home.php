<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $featuredProperties = Property::featured()
            ->available()
            ->limit(6)
            ->get();

        return view('livewire.home', [
            'featuredProperties' => $featuredProperties
        ])->layout('layouts.app');
    }
}
