<?php

namespace App\Livewire\Admin\Contacts;

use Livewire\Component;
use Livewire\WithPagination;

class ContactList extends Component
{
    use WithPagination;

    public function render()
    {
        // Contact model n'existe plus - fonctionnalité désactivée
        $contacts = collect([]);
        
        return view('livewire.admin.contacts.contact-list', [
            'contacts' => $contacts,
        ])->layout('layouts.admin');
    }
}
