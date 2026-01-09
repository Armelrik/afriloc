<?php

namespace App\Livewire\Admin\Components;

use App\Models\Promoteur;
use Livewire\Component;

class Sidebar extends Component
{
    public $isOpen = true;
    public $pendingPromotersCount = 0;
    public $urgentMaintenanceCount = 0;

    public function mount()
    {
        $this->pendingPromotersCount = Promoteur::enAttente()->count();
        // MaintenanceRequest n'existe plus, donc on met 0
        $this->urgentMaintenanceCount = 0;
    }

    public function toggleSidebar()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function render()
    {
        return view('livewire.admin.components.sidebar');
    }

    public function isActive($route)
    {
        return request()->routeIs($route);
    }
}


