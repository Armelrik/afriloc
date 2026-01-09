<?php

namespace App\Livewire\Promoter\Properties;

use App\Models\Bien;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class PropertyForm extends Component
{
    use WithFileUploads;

    public $propertyId = null;
    public $titre, $description;
    public $type_bien;
    public $prix_location, $frequence_location = 'mensuel';
    public $depot_garantie, $avance;
    public $superficie, $nombre_pieces, $nombre_chambres, $nombre_salles_bain;
    public $ville, $quartier, $adresse;
    public $disponibilite = 'disponible';
    public $statut = 'brouillon';
    public $est_publie = false;

    public function mount($id = null)
    {
        if ($id) {
            $this->propertyId = $id;
            $property = Bien::where('promoteur_id', Auth::user()->promoteur->id)->findOrFail($id);
            
            $this->fill($property->only([
                'titre', 'description', 'type_bien', 'prix_location', 'frequence_location',
                'depot_garantie', 'avance', 'superficie', 'nombre_pieces', 'nombre_chambres',
                'nombre_salles_bain', 'ville', 'quartier', 'adresse', 'disponibilite',
                'statut', 'est_publie',
            ]));
        }
    }

    protected function rules()
    {
        return [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'type_bien' => 'required|string',
            'prix_location' => 'required|numeric|min:0',
            'frequence_location' => 'required|in:quotidien,hebdomadaire,mensuel,annuel',
            'depot_garantie' => 'nullable|numeric|min:0',
            'avance' => 'nullable|numeric|min:0',
            'superficie' => 'required|numeric|min:0',
            'nombre_pieces' => 'required|integer|min:0',
            'nombre_chambres' => 'required|integer|min:0',
            'nombre_salles_bain' => 'required|integer|min:0',
            'ville' => 'required|string',
            'quartier' => 'nullable|string',
            'adresse' => 'required|string',
            'disponibilite' => 'required|in:disponible,loue,vendu,maintenance',
            'statut' => 'required|in:brouillon,en_attente,publie,archive',
            'est_publie' => 'boolean',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'promoteur_id' => Auth::user()->promoteur->id,
            'titre' => $this->titre,
            'description' => $this->description,
            'type_bien' => $this->type_bien,
            'prix_location' => $this->prix_location,
            'frequence_location' => $this->frequence_location,
            'depot_garantie' => $this->depot_garantie ?? 0,
            'avance' => $this->avance ?? 0,
            'superficie' => $this->superficie,
            'nombre_pieces' => $this->nombre_pieces,
            'nombre_chambres' => $this->nombre_chambres,
            'nombre_salles_bain' => $this->nombre_salles_bain,
            'ville' => $this->ville,
            'quartier' => $this->quartier,
            'adresse' => $this->adresse,
            'disponibilite' => $this->disponibilite,
            'statut' => $this->statut,
            'est_publie' => $this->est_publie,
            'date_ajout' => now(),
        ];

        if ($this->propertyId) {
            $property = Bien::where('promoteur_id', Auth::user()->promoteur->id)->findOrFail($this->propertyId);
            $property->update($data);
            session()->flash('success', __('messages.properties.updated'));
        } else {
            Bien::create($data);
            session()->flash('success', __('messages.properties.created'));
        }

        return redirect()->route('promoter.properties');
    }

    public function render()
    {
        return view('livewire.promoter.properties.property-form')->layout('layouts.app');
    }
}
