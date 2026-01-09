<?php

namespace App\Livewire\Admin\Promoters;

use App\Models\Promoteur;
use App\Models\HistoriqueValidation;
use Livewire\Component;

class PromoterDetail extends Component
{
    public $promoter;
    public $showSuspendModal = false;
    public $showActivateModal = false;
    public $showDeleteModal = false;

    public function mount($id)
    {
        $this->promoter = Promoteur::with([
            'user',
            'validePar',
            'demandeValidation.traitePar',
            'historiqueValidations.effectuePar',
            'biens'
        ])->findOrFail($id);
    }

    public function openSuspendModal()
    {
        $this->showSuspendModal = true;
    }

    public function openActivateModal()
    {
        $this->showActivateModal = true;
    }

    public function openDeleteModal()
    {
        $this->showDeleteModal = true;
    }

    public function suspend()
    {
        $this->promoter->update(['statut' => 'SUSPENDU']);
        
        // Créer entrée dans l'historique
        HistoriqueValidation::creer(
            $this->promoter->id,
            auth()->id(),
            'SUSPENDU',
            $this->promoter->getOriginal('statut'),
            'SUSPENDU',
            'Promoteur suspendu par l\'administrateur'
        );

        session()->flash('success', 'Promoteur suspendu avec succès.');
        $this->closeModals();
        $this->promoter->refresh();
    }

    public function activate()
    {
        $this->promoter->update(['statut' => 'VALIDE']);
        
        // Créer entrée dans l'historique
        HistoriqueValidation::creer(
            $this->promoter->id,
            auth()->id(),
            'REACTIVE',
            $this->promoter->getOriginal('statut'),
            'VALIDE',
            'Promoteur réactivé par l\'administrateur'
        );

        session()->flash('success', 'Promoteur réactivé avec succès.');
        $this->closeModals();
        $this->promoter->refresh();
    }

    public function delete()
    {
        $this->promoter->delete();
        session()->flash('success', 'Promoteur supprimé avec succès.');
        return redirect()->route('admin.promoters');
    }

    public function closeModals()
    {
        $this->showSuspendModal = false;
        $this->showActivateModal = false;
        $this->showDeleteModal = false;
    }

    public function render()
    {
        $historique = $this->promoter->historiqueValidations()
            ->with('effectuePar')
            ->latest('date_action')
            ->get();

        $biens = $this->promoter->biens()->with('medias')->latest()->get();
        $scoreCompletude = $this->promoter->calculerScoreCompletude();

        return view('livewire.admin.promoters.promoter-detail', [
            'historique' => $historique,
            'biens' => $biens,
            'scoreCompletude' => $scoreCompletude,
        ])->layout('layouts.admin');
    }
}

