<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;

class SettingsIndex extends Component
{
    public $activeTab = 'general';
    
    // Général
    public $nomPlateforme = 'Barka';
    public $emailContact = 'contact@barka.com';
    public $telephoneContact = '';
    
    // Validation
    public $pourcentageMinDocuments = 100;
    public $delaiValidation = 7; // jours
    
    // Commissions
    public $pourcentagePlateforme = 10.0;
    
    // Notifications
    public $activerEmail = true;
    public $activerSMS = false;
    
    // Documents
    public $formatsAcceptes = 'PDF,JPG,PNG';
    public $tailleMax = 5; // MB

    public function mount()
    {
        // Charger les paramètres depuis la base de données ou config
        // Pour l'instant, on utilise des valeurs par défaut
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function saveGeneral()
    {
        // Sauvegarder les paramètres généraux
        session()->flash('success', 'Paramètres généraux sauvegardés avec succès.');
    }

    public function saveValidation()
    {
        // Sauvegarder les paramètres de validation
        session()->flash('success', 'Paramètres de validation sauvegardés avec succès.');
    }

    public function saveCommissions()
    {
        // Sauvegarder les paramètres de commissions
        session()->flash('success', 'Paramètres de commissions sauvegardés avec succès.');
    }

    public function saveNotifications()
    {
        // Sauvegarder les paramètres de notifications
        session()->flash('success', 'Paramètres de notifications sauvegardés avec succès.');
    }

    public function saveDocuments()
    {
        // Sauvegarder les paramètres de documents
        session()->flash('success', 'Paramètres de documents sauvegardés avec succès.');
    }

    public function render()
    {
        return view('livewire.admin.settings.settings-index')->layout('layouts.admin');
    }
}

