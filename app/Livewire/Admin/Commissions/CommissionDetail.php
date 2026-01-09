<?php

namespace App\Livewire\Admin\Commissions;

use App\Models\Commission;
use Livewire\Component;

class CommissionDetail extends Component
{
    public $commission;

    public function mount($id)
    {
        $this->commission = Commission::with([
            'promoteur.user',
            'paiement.reservation.bien',
            'paiement.reservation.client'
        ])->findOrFail($id);
    }

    public function transferer()
    {
        $this->commission->transfererPromoteur();
        session()->flash('success', 'Commission transférée au promoteur avec succès.');
        $this->commission->refresh();
    }

    public function render()
    {
        return view('livewire.admin.commissions.commission-detail')->layout('layouts.admin');
    }
}

