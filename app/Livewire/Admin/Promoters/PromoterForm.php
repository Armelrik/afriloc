<?php

namespace App\Livewire\Admin\Promoters;

use App\Models\Promoteur;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

class PromoterForm extends Component
{
    use WithFileUploads;

    public $promoterId = null;
    public $isEdit = false;
    
    // User fields
    public $user_id = '';
    public $nom = '';
    public $prenom = '';
    public $email = '';
    public $telephone = '';
    public $password = '';
    public $password_confirmation = '';
    
    // Promoteur fields
    public $raison_sociale = '';
    public $type_structure = '';
    public $numero_siret = '';
    public $adresse_professionnelle = '';
    public $ville = '';
    public $description = '';
    public $statut = 'EN_ATTENTE';

    public function mount($id = null)
    {
        if ($id) {
            $this->promoterId = $id;
            $this->isEdit = true;
            $promoter = Promoteur::with('user')->findOrFail($id);
            
            $this->user_id = $promoter->user_id;
            $this->nom = $promoter->user->nom ?? '';
            $this->prenom = $promoter->user->prenom ?? '';
            $this->email = $promoter->user->email ?? '';
            $this->telephone = $promoter->user->telephone ?? '';
            
            $this->raison_sociale = $promoter->raison_sociale ?? '';
            $this->type_structure = $promoter->type_structure ?? '';
            $this->numero_siret = $promoter->numero_siret ?? '';
            $this->adresse_professionnelle = $promoter->adresse_professionnelle ?? '';
            $this->ville = $promoter->ville ?? '';
            $this->description = $promoter->description ?? '';
            $this->statut = $promoter->statut ?? 'EN_ATTENTE';
        }
    }

    protected function rules()
    {
        $rules = [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email' . ($this->isEdit ? ',' . $this->user_id : ''),
            'telephone' => 'nullable|string|max:20',
            'raison_sociale' => 'required|string|max:255',
            'type_structure' => 'required|string|max:255',
            'numero_siret' => 'nullable|string|max:50',
            'adresse_professionnelle' => 'required|string|max:500',
            'ville' => 'required|string|max:255',
            'description' => 'nullable|string',
            'statut' => 'required|in:EN_ATTENTE,VALIDE,INCOMPLET,REJETE,SUSPENDU',
        ];

        if (!$this->isEdit || !empty($this->password)) {
            $rules['password'] = 'required|min:8|confirmed';
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();

        // Create or update user
        if ($this->isEdit) {
            $user = User::findOrFail($this->user_id);
            $user->update([
                'nom' => $this->nom,
                'prenom' => $this->prenom,
                'email' => $this->email,
                'telephone' => $this->telephone,
                'type_utilisateur' => 'promoteur',
            ]);
            
            if (!empty($this->password)) {
                $user->update(['password' => Hash::make($this->password)]);
            }
        } else {
            $user = User::create([
                'nom' => $this->nom,
                'prenom' => $this->prenom,
                'email' => $this->email,
                'telephone' => $this->telephone,
                'password' => Hash::make($this->password),
                'type_utilisateur' => 'promoteur',
                'est_actif' => true,
                'date_inscription' => now(),
            ]);
            
            // Assign promoter role
            $user->assignRole('promoter');
        }

        // Create or update promoter
        $promoterData = [
            'user_id' => $user->id,
            'raison_sociale' => $this->raison_sociale,
            'type_structure' => $this->type_structure,
            'numero_siret' => $this->numero_siret,
            'adresse_professionnelle' => $this->adresse_professionnelle,
            'ville' => $this->ville,
            'description' => $this->description,
            'statut' => $this->statut,
        ];

        if ($this->isEdit) {
            $promoter = Promoteur::findOrFail($this->promoterId);
            $promoter->update($promoterData);
            session()->flash('success', 'Promoteur modifié avec succès.');
        } else {
            $promoterData['date_inscription'] = now();
            $promoter = Promoteur::create($promoterData);
            session()->flash('success', 'Promoteur créé avec succès.');
        }

        return redirect()->route('admin.promoters.show', $promoter->id);
    }

    public function render()
    {
        return view('livewire.admin.promoters.promoter-form')->layout('layouts.admin');
    }
}

