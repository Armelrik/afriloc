<?php

namespace App\Livewire\Admin\Promoters;

use App\Models\Promoteur;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class PromoterList extends Component
{
    use WithPagination;

    public $filterStatus = '';

    public function approvePromoter($id)
    {
        $promoter = Promoteur::findOrFail($id);
        $adminId = auth()->id();
        $promoter->approuver($adminId);
        
        session()->flash('success', __('Promoter approved successfully'));
    }

    public function suspendPromoter($id)
    {
        $promoter = Promoteur::findOrFail($id);
        $promoter->update(['statut' => 'SUSPENDU']);
        
        session()->flash('success', __('Promoter suspended'));
    }

    public function approve($id)
    {
        $this->approvePromoter($id);
    }

    public function reject($id)
    {
        $promoter = Promoteur::findOrFail($id);
        $adminId = auth()->id();
        $promoter->rejeter($adminId, 'Rejeté par l\'administrateur');
        
        session()->flash('success', __('Promoter rejected'));
    }

    public function suspend($id)
    {
        $this->suspendPromoter($id);
    }

    public function activate($id)
    {
        $promoter = Promoteur::findOrFail($id);
        $promoter->update(['statut' => 'VALIDE']);
        
        session()->flash('success', __('Promoter activated'));
    }

    public function viewDetails($id)
    {
        // Redirect to promoter details page
        return redirect()->route('admin.promoters.show', $id);
    }

    public function render()
    {
        $promoters = Promoteur::with('user')
            ->when($this->filterStatus, function ($query) {
                $query->where('statut', $this->filterStatus);
            })
            ->latest()
            ->paginate(15);

        return view('livewire.admin.promoters.promoter-list', [
            'promoters' => $promoters,
        ])->layout('layouts.admin');
    }
}
