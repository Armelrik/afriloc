<?php

namespace App\Livewire\Admin\Maintenance;

use App\Models\MaintenanceRequest;
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
        $query = MaintenanceRequest::with(['user', 'property', 'booking']);

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->priorityFilter) {
            $query->where('priority', $this->priorityFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($u) {
                      $u->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('property', function ($p) {
                      $p->where('title_en', 'like', '%' . $this->search . '%')
                        ->orWhere('title_fr', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $maintenanceRequests = $query->latest()->paginate(15);

        $stats = [
            'total' => MaintenanceRequest::count(),
            'pending' => MaintenanceRequest::pending()->count(),
            'in_progress' => MaintenanceRequest::where('status', 'in_progress')->count(),
            'completed' => MaintenanceRequest::where('status', 'completed')->count(),
            'urgent' => MaintenanceRequest::urgent()->whereIn('status', ['pending', 'in_progress'])->count(),
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


