<?php

namespace App\Livewire\Admin\Renewals;

use App\Models\Renewal;
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
        $query = Renewal::with(['user', 'property', 'booking']);

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('user', function ($u) {
                    $u->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('property', function ($p) {
                    $p->where('title_en', 'like', '%' . $this->search . '%')
                      ->orWhere('title_fr', 'like', '%' . $this->search . '%');
                });
            });
        }

        $renewals = $query->latest()->paginate(15);

        $stats = [
            'total' => Renewal::count(),
            'pending' => Renewal::where('status', 'pending')->count(),
            'approved' => Renewal::where('status', 'approved')->count(),
            'rejected' => Renewal::where('status', 'rejected')->count(),
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


