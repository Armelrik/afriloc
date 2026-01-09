<?php

namespace App\Livewire\Admin\Validations;

use App\Models\DemandeValidation;
use App\Models\HistoriqueValidation;
use Livewire\Component;
use Livewire\WithPagination;

class ValidationList extends Component
{
    use WithPagination;

    public $filterStatus = '';
    public $search = '';
    public $selectedValidation = null;
    public $showApproveModal = false;
    public $showRejectModal = false;
    public $showIncompleteModal = false;
    public $rejectMotif = '';
    public $incompleteCommentaires = '';

    public function mount()
    {
        $this->filterStatus = request()->get('status', '');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function viewDetails($id)
    {
        return redirect()->route('admin.validations.show', $id);
    }

    public function openApproveModal($id)
    {
        $this->selectedValidation = DemandeValidation::with(['promoteur.user', 'traitePar'])->findOrFail($id);
        $this->showApproveModal = true;
    }

    public function openRejectModal($id)
    {
        $this->selectedValidation = DemandeValidation::with(['promoteur.user', 'traitePar'])->findOrFail($id);
        $this->rejectMotif = '';
        $this->showRejectModal = true;
    }

    public function openIncompleteModal($id)
    {
        $this->selectedValidation = DemandeValidation::with(['promoteur.user', 'traitePar'])->findOrFail($id);
        $this->incompleteCommentaires = '';
        $this->showIncompleteModal = true;
    }

    public function approve()
    {
        if (!$this->selectedValidation) {
            return;
        }

        $adminId = auth()->id();
        $this->selectedValidation->approuver($adminId);

        // Créer entrée dans l'historique
        HistoriqueValidation::creer(
            $this->selectedValidation->promoteur_id,
            $adminId,
            'APPROUVEE',
            'EN_ATTENTE',
            'VALIDE',
            'Demande de validation approuvée par l\'administrateur'
        );

        session()->flash('success', 'Demande de validation approuvée avec succès.');
        $this->closeModals();
        $this->selectedValidation = null;
    }

    public function reject()
    {
        if (!$this->selectedValidation || empty($this->rejectMotif)) {
            session()->flash('error', 'Veuillez fournir un motif de rejet.');
            return;
        }

        $adminId = auth()->id();
        $this->selectedValidation->rejeter($adminId, $this->rejectMotif);

        // Créer entrée dans l'historique
        HistoriqueValidation::creer(
            $this->selectedValidation->promoteur_id,
            $adminId,
            'REJETEE',
            'EN_ATTENTE',
            'REJETE',
            'Motif: ' . $this->rejectMotif
        );

        session()->flash('success', 'Demande de validation rejetée.');
        $this->closeModals();
        $this->selectedValidation = null;
        $this->rejectMotif = '';
    }

    public function requestIncomplete()
    {
        if (!$this->selectedValidation || empty($this->incompleteCommentaires)) {
            session()->flash('error', 'Veuillez fournir des commentaires.');
            return;
        }

        $adminId = auth()->id();
        $this->selectedValidation->demanderComplement($adminId, $this->incompleteCommentaires);

        // Créer entrée dans l'historique
        HistoriqueValidation::creer(
            $this->selectedValidation->promoteur_id,
            $adminId,
            'COMPLEMENT_DEMANDE',
            'EN_ATTENTE',
            'INCOMPLET',
            $this->incompleteCommentaires
        );

        session()->flash('success', 'Demande de complément envoyée au promoteur.');
        $this->closeModals();
        $this->selectedValidation = null;
        $this->incompleteCommentaires = '';
    }

    public function closeModals()
    {
        $this->showApproveModal = false;
        $this->showRejectModal = false;
        $this->showIncompleteModal = false;
    }

    public function render()
    {
        $validations = DemandeValidation::with(['promoteur.user', 'traitePar'])
            ->when($this->filterStatus, function ($query) {
                $query->where('statut', $this->filterStatus);
            })
            ->when($this->search, function ($query) {
                $query->whereHas('promoteur', function ($q) {
                    $q->where('raison_sociale', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($uq) {
                            $uq->where('nom', 'like', '%' . $this->search . '%')
                                ->orWhere('prenom', 'like', '%' . $this->search . '%')
                                ->orWhere('email', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->latest('date_demande')
            ->paginate(15);

        $pendingCount = DemandeValidation::where('statut', 'EN_ATTENTE')->count();

        return view('livewire.admin.validations.validation-list', [
            'validations' => $validations,
            'pendingCount' => $pendingCount,
        ])->layout('layouts.admin');
    }
}

