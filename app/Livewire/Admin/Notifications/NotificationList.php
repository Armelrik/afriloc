<?php

namespace App\Livewire\Admin\Notifications;

use App\Models\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationList extends Component
{
    use WithPagination;

    public $filterType = '';
    public $filterPriorite = '';
    public $filterStatut = '';
    public $filterCanal = '';
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function updatingFilterPriorite()
    {
        $this->resetPage();
    }

    public function updatingFilterStatut()
    {
        $this->resetPage();
    }

    public function updatingFilterCanal()
    {
        $this->resetPage();
    }

    public function marquerCommeLue($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->marquerCommeLue();
        session()->flash('success', 'Notification marquée comme lue.');
    }

    public function marquerCommeNonLue($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['est_lue' => false, 'date_lecture' => null]);
        session()->flash('success', 'Notification marquée comme non lue.');
    }

    public function render()
    {
        $notifications = Notification::with('utilisateur')
            ->when($this->filterType, function ($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterPriorite, function ($query) {
                $query->where('priorite', $this->filterPriorite);
            })
            ->when($this->filterStatut !== '', function ($query) {
                $query->where('est_lue', $this->filterStatut === '1');
            })
            ->when($this->filterCanal, function ($query) {
                $query->where('canal', $this->filterCanal);
            })
            ->when($this->search, function ($query) {
                $query->where('contenu', 'like', '%' . $this->search . '%')
                    ->orWhereHas('utilisateur', function ($q) {
                        $q->where('nom', 'like', '%' . $this->search . '%')
                            ->orWhere('prenom', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
            })
            ->latest('date_envoi')
            ->paginate(20);

        $types = Notification::distinct()->pluck('type')->filter();
        $canaux = Notification::distinct()->pluck('canal')->filter();

        return view('livewire.admin.notifications.notification-list', [
            'notifications' => $notifications,
            'types' => $types,
            'canaux' => $canaux,
        ])->layout('layouts.admin');
    }
}

