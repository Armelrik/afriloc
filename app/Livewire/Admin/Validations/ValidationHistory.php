<?php

namespace App\Livewire\Admin\Validations;

use App\Models\HistoriqueValidation;
use App\Models\Promoteur;
use Livewire\Component;
use Livewire\WithPagination;

class ValidationHistory extends Component
{
    use WithPagination;

    public $filterPromoter = '';
    public $filterAdmin = '';
    public $filterAction = '';
    public $dateFrom = '';
    public $dateTo = '';

    public function updatingFilterPromoter()
    {
        $this->resetPage();
    }

    public function updatingFilterAdmin()
    {
        $this->resetPage();
    }

    public function updatingFilterAction()
    {
        $this->resetPage();
    }

    public function render()
    {
        $history = HistoriqueValidation::with(['promoteur.user', 'effectuePar'])
            ->when($this->filterPromoter, function ($query) {
                $query->where('promoteur_id', $this->filterPromoter);
            })
            ->when($this->filterAdmin, function ($query) {
                $query->where('effectue_par_id', $this->filterAdmin);
            })
            ->when($this->filterAction, function ($query) {
                $query->where('action', $this->filterAction);
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('date_action', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->whereDate('date_action', '<=', $this->dateTo);
            })
            ->latest('date_action')
            ->paginate(20);

        $promoters = Promoteur::with('user')->get();
        $admins = \App\Models\User::whereHas('roles', function ($q) {
            $q->where('name', 'admin');
        })->get();
        $actions = HistoriqueValidation::distinct()->pluck('action');

        return view('livewire.admin.validations.validation-history', [
            'history' => $history,
            'promoters' => $promoters,
            'admins' => $admins,
            'actions' => $actions,
        ])->layout('layouts.admin');
    }
}

