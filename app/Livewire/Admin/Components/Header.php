<?php

namespace App\Livewire\Admin\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Component
{
    public function render()
    {
        $user = Auth::user();
        
        return view('livewire.admin.components.header', [
            'user' => $user,
        ]);
    }

    public function changeLanguage($lang)
    {
        session(['locale' => $lang]);
        return redirect()->back();
    }
}


