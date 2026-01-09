<?php

namespace App\Livewire\Admin\Maintenance;

use Livewire\Component;
use Livewire\WithPagination;

class MaintenanceList extends Component
{
    use WithPagination;

    public $statusFilter = '';
    public $priorityFilter = '';
    public $search = '';

    protected $queryString = ['statusFilter' => ['except' => ''], 'priorityFilter' => ['except' => ''], 'search' => ['except' => '']];

    public function render()
    {
        // MaintenanceRequest model n'existe plus - fonctionnalité désactivée
        $maintenanceRequests = collect([]);

        $stats = [
            'total' => 0,
            'pending' => 0,
            'in_progress' => 0,
            'completed' => 0,
            'urgent' => 0,
        ];

        return view('livewire.admin.maintenance.maintenance-list', [
            'maintenanceRequests' => $maintenanceRequests,
            'stats' => $stats,
        ])->layout('layouts.admin');
    }

    public function clearFilters()
    {
        $this->reset(['statusFilter', 'priorityFilter', 'search']);
    }
}
