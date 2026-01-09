<?php

namespace App\Livewire;

use App\Models\Bien;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $featuredProperties = Bien::publie()
            ->disponible()
            ->limit(6)
            ->get();

        return view('livewire.home', [
            'featuredProperties' => $featuredProperties
        ])->layout('layouts.app');
    }
}
