<?php

namespace App\Livewire\Admin\Renewals;

use Livewire\Component;
use Livewire\WithPagination;

class RenewalList extends Component
{
    use WithPagination;

    public $statusFilter = '';
    public $search = '';

    protected $queryString = ['statusFilter' => ['except' => ''], 'search' => ['except' => '']];

    public function render()
    {
        // Renewal model n'existe plus - fonctionnalité désactivée
        $renewals = collect([]);

        $stats = [
            'total' => 0,
            'pending' => 0,
            'approved' => 0,
            'rejected' => 0,
        ];

        return view('livewire.admin.renewals.renewal-list', [
            'renewals' => $renewals,
            'stats' => $stats,
        ])->layout('layouts.admin');
    }

    public function clearFilters()
    {
        $this->reset(['statusFilter', 'search']);
    }
}
