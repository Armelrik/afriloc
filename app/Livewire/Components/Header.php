<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Header extends Component
{
    public $mobileMenuOpen = false;

    public function switchLanguage($lang)
    {
        session(['locale' => $lang]);
        app()->setLocale($lang);
        
        $this->dispatch('languageChanged');
        
        return redirect(request()->header('Referer'));
    }

    public function toggleMobileMenu()
    {
        $this->mobileMenuOpen = !$this->mobileMenuOpen;
    }

    public function render()
    {
        return view('livewire.components.header');
    }
}
