<?php

namespace App\Livewire\Admin\Components;

use App\Models\MaintenanceRequest;
use App\Models\Promoter;
use Livewire\Component;

class Sidebar extends Component
{
    public $isOpen = true;
    public $pendingPromotersCount = 0;
    public $urgentMaintenanceCount = 0;

    public function mount()
    {
        $this->pendingPromotersCount = Promoter::pending()->count();
        $this->urgentMaintenanceCount = MaintenanceRequest::urgent()
            ->whereIn('status', ['pending', 'in_progress'])
            ->count();
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


