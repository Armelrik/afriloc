<?php

namespace App\Livewire\Promoter;

use App\Models\Promoteur;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Registration extends Component
{
    use WithFileUploads;

    public $step = 1;
    
    // Step 1: User account
    public $nom = '';
    public $prenom = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    
    // Step 2: Professional info
    public $raison_sociale = '';
    public $type_structure = '';
    public $numero_siret = '';
    public $adresse_professionnelle = '';
    public $ville = '';
    public $phone = '';
    public $whatsapp = '';
    public $description = '';
    
    // Step 3: Documents
    public $cnib_recto;
    public $cnib_verso;
    public $photo_promoteur;
    public $justificatif_domicile;
    public $registre_commerce;
    public $attestation_fiscale;
    public $certificat_propriete;
    public $assurance_rc;

    protected function rules()
    {
        $rules = [];
        
        if ($this->step === 1) {
            $rules = [
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
            ];
        } elseif ($this->step === 2) {
            $rules = [
                'raison_sociale' => 'required|string|max:255',
                'type_structure' => 'required|string',
                'numero_siret' => 'nullable|string|max:50',
                'adresse_professionnelle' => 'required|string',
                'ville' => 'required|string|max:100',
                'phone' => 'required|string|max:20',
                'description' => 'nullable|string',
            ];
        } elseif ($this->step === 3) {
            $rules = [
                'cnib_recto' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'cnib_verso' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'photo_promoteur' => 'required|file|mimes:jpg,jpeg,png|max:5120',
                'justificatif_domicile' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'registre_commerce' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'attestation_fiscale' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'certificat_propriete' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'assurance_rc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            ];
        }
        
        return $rules;
    }

    public function nextStep()
    {
        $this->validate();
        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function submit()
    {
        if ($this->step === 3) {
            $this->validate();
            
            // Create user account
            $user = User::create([
                'name' => $this->nom . ' ' . $this->prenom,
                'nom' => $this->nom,
                'prenom' => $this->prenom,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'type_utilisateur' => 'promoteur',
                'date_inscription' => now(),
                'est_actif' => true,
            ]);
            
            $user->assignRole('promoter');
            
            // Upload documents
            $documentData = [];
            
            if ($this->cnib_recto) {
                $documentData['cnib_recto'] = $this->cnib_recto->store('promoter-documents', 'public');
            }
            if ($this->cnib_verso) {
                $documentData['cnib_verso'] = $this->cnib_verso->store('promoter-documents', 'public');
            }
            if ($this->photo_promoteur) {
                $documentData['photo_promoteur'] = $this->photo_promoteur->store('promoter-documents', 'public');
            }
            if ($this->justificatif_domicile) {
                $documentData['justificatif_domicile'] = $this->justificatif_domicile->store('promoter-documents', 'public');
            }
            if ($this->registre_commerce) {
                $documentData['registre_commerce'] = $this->registre_commerce->store('promoter-documents', 'public');
            }
            if ($this->attestation_fiscale) {
                $documentData['attestation_fiscale'] = $this->attestation_fiscale->store('promoter-documents', 'public');
            }
            if ($this->certificat_propriete) {
                $documentData['certificat_propriete'] = $this->certificat_propriete->store('promoter-documents', 'public');
            }
            if ($this->assurance_rc) {
                $documentData['assurance_rc'] = $this->assurance_rc->store('promoter-documents', 'public');
            }
            
            // Create promoter profile
            Promoteur::create([
                'user_id' => $user->id,
                'raison_sociale' => $this->raison_sociale,
                'type_structure' => $this->type_structure,
                'numero_siret' => $this->numero_siret,
                'adresse_professionnelle' => $this->adresse_professionnelle,
                'ville' => $this->ville,
                'description' => $this->description,
                'statut' => 'EN_ATTENTE',
                'date_inscription' => now(),
                ...$documentData,
            ]);
            
            Auth::login($user);
            
            session()->flash('success', __('Your application has been submitted successfully. You will be notified once it is approved.'));
            
            return redirect()->route('promoter.pending');
        }
    }

    public function generateRandomSiret()
    {
        return implode('', array_map(fn() => rand(0, 9), range(1, 14)));
    }

    public function render()
    {
        return view('livewire.promoter.registration', [
            'randomSiret' => $this->generateRandomSiret(),
        ])->layout('layouts.app');
    }
}
