<?php

namespace App\Livewire\Admin\Promoters;

use App\Models\Promoter;
use Livewire\Component;
use Livewire\WithPagination;

class PromoterList extends Component
{
    use WithPagination;

    public $filterStatus = '';

    public function approvePromoter($id)
    {
        $promoter = Promoter::findOrFail($id);
        $promoter->approve();
        
        session()->flash('success', __('Promoter approved successfully'));
    }

    public function suspendPromoter($id)
    {
        $promoter = Promoter::findOrFail($id);
        $promoter->update(['status' => 'suspended']);
        
        session()->flash('success', __('Promoter suspended'));
    }

    public function render()
    {
        $promoters = Promoter::with('user')
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->latest()
            ->paginate(15);

        return view('livewire.admin.promoters.promoter-list', [
            'promoters' => $promoters,
        ])->layout('layouts.admin');
    }
}
