<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Header extends Component
{
    public function switchLanguage($locale)
    {
        Session::put('locale', $locale);
        $this->redirect(request()->header('Referer'), navigate: true);
    }

    public function render()
    {
        return view('livewire.components.header');
    }
}
