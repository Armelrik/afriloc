<?php

namespace App\Livewire\Admin\Validations;

use App\Models\DemandeValidation;
use App\Models\HistoriqueValidation;
use Livewire\Component;

class ValidationDetail extends Component
{
    public $validation;
    public $showApproveModal = false;
    public $showRejectModal = false;
    public $showIncompleteModal = false;
    public $rejectMotif = '';
    public $incompleteCommentaires = '';

    public function mount($id)
    {
        $this->validation = DemandeValidation::with([
            'promoteur.user',
            'traitePar',
            'promoteur.historiqueValidations.effectuePar'
        ])->findOrFail($id);
    }

    public function openApproveModal()
    {
        $this->showApproveModal = true;
    }

    public function openRejectModal()
    {
        $this->rejectMotif = '';
        $this->showRejectModal = true;
    }

    public function openIncompleteModal()
    {
        $this->incompleteCommentaires = '';
        $this->showIncompleteModal = true;
    }

    public function approve()
    {
        $adminId = auth()->id();
        $this->validation->approuver($adminId);

        // Créer entrée dans l'historique
        HistoriqueValidation::creer(
            $this->validation->promoteur_id,
            $adminId,
            'APPROUVEE',
            'EN_ATTENTE',
            'VALIDE',
            'Demande de validation approuvée par l\'administrateur'
        );

        session()->flash('success', 'Demande de validation approuvée avec succès.');
        $this->closeModals();
        $this->validation->refresh();
    }

    public function reject()
    {
        if (empty($this->rejectMotif)) {
            session()->flash('error', 'Veuillez fournir un motif de rejet.');
            return;
        }

        $adminId = auth()->id();
        $this->validation->rejeter($adminId, $this->rejectMotif);

        // Créer entrée dans l'historique
        HistoriqueValidation::creer(
            $this->validation->promoteur_id,
            $adminId,
            'REJETEE',
            'EN_ATTENTE',
            'REJETE',
            'Motif: ' . $this->rejectMotif
        );

        session()->flash('success', 'Demande de validation rejetée.');
        $this->closeModals();
        $this->rejectMotif = '';
        $this->validation->refresh();
    }

    public function requestIncomplete()
    {
        if (empty($this->incompleteCommentaires)) {
            session()->flash('error', 'Veuillez fournir des commentaires.');
            return;
        }

        $adminId = auth()->id();
        $this->validation->demanderComplement($adminId, $this->incompleteCommentaires);

        // Créer entrée dans l'historique
        HistoriqueValidation::creer(
            $this->validation->promoteur_id,
            $adminId,
            'COMPLEMENT_DEMANDE',
            'EN_ATTENTE',
            'INCOMPLET',
            $this->incompleteCommentaires
        );

        session()->flash('success', 'Demande de complément envoyée au promoteur.');
        $this->closeModals();
        $this->incompleteCommentaires = '';
        $this->validation->refresh();
    }

    public function closeModals()
    {
        $this->showApproveModal = false;
        $this->showRejectModal = false;
        $this->showIncompleteModal = false;
    }

    public function render()
    {
        $historique = HistoriqueValidation::where('promoteur_id', $this->validation->promoteur_id)
            ->with('effectuePar')
            ->latest('date_action')
            ->get();

        return view('livewire.admin.validations.validation-detail', [
            'historique' => $historique,
        ])->layout('layouts.admin');
    }
}

