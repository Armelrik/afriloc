<?php

namespace App\Livewire\Admin\Notifications;

use App\Models\Notification;
use App\Models\User;
use Livewire\Component;

class NotificationCreate extends Component
{
    public $utilisateur_id = '';
    public $type = 'INFO';
    public $canal = 'EMAIL';
    public $contenu = '';
    public $priorite = 'NORMALE';
    public $users = [];

    public function mount()
    {
        $this->users = User::where('est_actif', true)->get();
    }

    public function rules()
    {
        return [
            'utilisateur_id' => 'required|exists:users,id',
            'type' => 'required|in:VALIDATION,RESERVATION,PAIEMENT,REJET,INFO',
            'canal' => 'required|in:EMAIL,SMS,IN_APP',
            'contenu' => 'required|string|min:10|max:500',
            'priorite' => 'required|in:URGENTE,HAUTE,NORMALE',
        ];
    }

    public function messages()
    {
        return [
            'utilisateur_id.required' => 'Veuillez sélectionner un utilisateur.',
            'contenu.required' => 'Le contenu est requis.',
            'contenu.min' => 'Le contenu doit contenir au moins 10 caractères.',
            'contenu.max' => 'Le contenu ne peut pas dépasser 500 caractères.',
        ];
    }

    public function envoyer()
    {
        $this->validate();

        $notification = Notification::create([
            'utilisateur_id' => $this->utilisateur_id,
            'type' => $this->type,
            'canal' => $this->canal,
            'contenu' => $this->contenu,
            'priorite' => $this->priorite,
            'date_envoi' => now(),
            'est_lue' => false,
        ]);

        // Envoyer selon le canal
        if ($this->canal === 'EMAIL') {
            $notification->envoyerEmail();
        } elseif ($this->canal === 'SMS') {
            $notification->envoyerSMS();
        }

        session()->flash('success', 'Notification envoyée avec succès.');
        
        return redirect()->route('admin.notifications.index');
    }

    public function render()
    {
        return view('livewire.admin.notifications.notification-create')->layout('layouts.admin');
    }
}

