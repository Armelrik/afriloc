<?php

namespace App\Livewire\Admin\Properties;

use App\Models\Bien;
use Livewire\Component;

class PropertyDetail extends Component
{
    public $property;
    public $showPublishModal = false;
    public $showUnpublishModal = false;
    public $showDeleteModal = false;

    public function mount($id)
    {
        $this->property = Bien::with([
            'promoteur.user',
            'medias',
            'reservations.client',
            'reservations.paiement'
        ])->findOrFail($id);
    }

    public function openPublishModal()
    {
        $this->showPublishModal = true;
    }

    public function openUnpublishModal()
    {
        $this->showUnpublishModal = true;
    }

    public function openDeleteModal()
    {
        $this->showDeleteModal = true;
    }

    public function publish()
    {
        $this->property->update([
            'est_publie' => true,
            'date_publication' => now(),
            'statut' => 'publie',
        ]);
        session()->flash('success', 'Bien publié avec succès.');
        $this->closeModals();
        $this->property->refresh();
    }

    public function unpublish()
    {
        $this->property->update([
            'est_publie' => false,
            'statut' => 'archive',
        ]);
        session()->flash('success', 'Bien dépublié avec succès.');
        $this->closeModals();
        $this->property->refresh();
    }

    public function delete()
    {
        $this->property->delete();
        session()->flash('success', 'Bien supprimé avec succès.');
        return redirect()->route('admin.properties');
    }

    public function closeModals()
    {
        $this->showPublishModal = false;
        $this->showUnpublishModal = false;
        $this->showDeleteModal = false;
    }

    public function render()
    {
        $reservations = $this->property->reservations()
            ->with(['client', 'paiement'])
            ->latest()
            ->get();

        $images = $this->property->medias()->where('type_media', 'IMAGE')->get();
        $videos = $this->property->medias()->where('type_media', 'VIDEO')->get();

        return view('livewire.admin.properties.property-detail', [
            'reservations' => $reservations,
            'images' => $images,
            'videos' => $videos,
        ])->layout('layouts.admin');
    }
}

