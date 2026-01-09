<?php

namespace App\Livewire\Admin\Commissions;

use App\Models\Commission;
use Livewire\Component;
use Livewire\WithPagination;

class CommissionList extends Component
{
    use WithPagination;

    public $filterTransfere = '';
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterTransfere()
    {
        $this->resetPage();
    }

    public function transferer($id)
    {
        $commission = Commission::findOrFail($id);
        $commission->transfererPromoteur();
        
        session()->flash('success', 'Commission transférée au promoteur avec succès.');
    }

    public function transfererPlusieurs(array $ids)
    {
        Commission::whereIn('id', $ids)
            ->where('est_transfere', false)
            ->update([
                'est_transfere' => true,
                'date_transfert' => now(),
            ]);
        
        session()->flash('success', count($ids) . ' commission(s) transférée(s) avec succès.');
    }

    public function viewDetails($id)
    {
        return redirect()->route('admin.commissions.show', $id);
    }

    public function render()
    {
        $commissions = Commission::with(['promoteur.user', 'paiement.reservation.bien'])
            ->when($this->filterTransfere !== '', function ($query) {
                $query->where('est_transfere', $this->filterTransfere === '1');
            })
            ->when($this->search, function ($query) {
                $query->whereHas('promoteur', function ($q) {
                    $q->where('raison_sociale', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($uq) {
                            $uq->where('nom', 'like', '%' . $this->search . '%')
                                ->orWhere('prenom', 'like', '%' . $this->search . '%');
                        });
                })
                ->orWhereHas('paiement', function ($q) {
                    $q->where('reference_transaction', 'like', '%' . $this->search . '%');
                });
            })
            ->latest('date_calcul')
            ->paginate(15);

        // Statistiques
        $totalCommissions = Commission::sum('montant_commission');
        $totalTransfere = Commission::where('est_transfere', true)->sum('montant_commission');
        $totalEnAttente = Commission::where('est_transfere', false)->sum('montant_commission');
        $totalPromoteur = Commission::sum('montant_promoteur');
        $countEnAttente = Commission::where('est_transfere', false)->count();

        return view('livewire.admin.commissions.commission-list', [
            'commissions' => $commissions,
            'totalCommissions' => $totalCommissions,
            'totalTransfere' => $totalTransfere,
            'totalEnAttente' => $totalEnAttente,
            'totalPromoteur' => $totalPromoteur,
            'countEnAttente' => $countEnAttente,
        ])->layout('layouts.admin');
    }
}

