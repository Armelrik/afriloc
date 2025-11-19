<?php

namespace App\Livewire\Admin\Contacts;

use App\Models\Contact;
use Livewire\Component;
use Livewire\WithPagination;

class ContactList extends Component
{
    use WithPagination;

    public function delete($id)
    {
        Contact::findOrFail($id)->delete();
        session()->flash('message', 'Contact message deleted successfully.');
    }

    public function render()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('livewire.admin.contacts.contact-list', compact('contacts'))->layout('layouts.admin');
    }
}

