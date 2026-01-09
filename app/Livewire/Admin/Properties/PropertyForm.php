<?php

namespace App\Livewire\Admin\Properties;

use App\Models\Bien;
use App\Models\Promoteur;
use App\Models\MediaBien;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PropertyForm extends Component
{
    use WithFileUploads;

    public $propertyId = null;
    public $isEdit = false;
    
    // Basic fields
    public $promoteur_id = '';
    public $titre = '';
    public $description = '';
    public $type_bien = '';
    public $adresse = '';
    public $ville = '';
    public $quartier = '';
    public $superficie = '';
    public $nombre_pieces = '';
    public $nombre_chambres = '';
    public $nombre_salles_bain = '';
    public $prix_location = '';
    public $frequence_location = 'mensuel';
    public $depot_garantie = '';
    public $avance = '';
    public $disponibilite = 'disponible';
    public $statut = 'brouillon';
    public $est_publie = false;
    
    // Media
    public $images = [];
    public $existingImages = [];
    public $videos = [];
    public $existingVideos = [];

    public function mount($id = null)
    {
        if ($id) {
            $this->propertyId = $id;
            $this->isEdit = true;
            $property = Bien::with(['medias', 'promoteur'])->findOrFail($id);
            
            $this->promoteur_id = $property->promoteur_id;
            $this->titre = $property->titre ?? '';
            $this->description = $property->description ?? '';
            $this->type_bien = $property->type_bien ?? '';
            $this->adresse = $property->adresse ?? '';
            $this->ville = $property->ville ?? '';
            $this->quartier = $property->quartier ?? '';
            $this->superficie = $property->superficie ?? '';
            $this->nombre_pieces = $property->nombre_pieces ?? '';
            $this->nombre_chambres = $property->nombre_chambres ?? '';
            $this->nombre_salles_bain = $property->nombre_salles_bain ?? '';
            $this->prix_location = $property->prix_location ?? '';
            $this->frequence_location = $property->frequence_location ?? 'mensuel';
            $this->depot_garantie = $property->depot_garantie ?? '';
            $this->avance = $property->avance ?? '';
            $this->disponibilite = $property->disponibilite ?? 'disponible';
            $this->statut = $property->statut ?? 'brouillon';
            $this->est_publie = $property->est_publie ?? false;
            
            // Existing media
            $this->existingImages = $property->medias()->where('type_media', 'IMAGE')->get();
            $this->existingVideos = $property->medias()->where('type_media', 'VIDEO')->get();
        }
    }

    protected function rules()
    {
        return [
            'promoteur_id' => 'required|exists:promoteurs,id',
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'type_bien' => 'required|string|max:255',
            'adresse' => 'required|string|max:500',
            'ville' => 'required|string|max:255',
            'quartier' => 'nullable|string|max:255',
            'superficie' => 'required|numeric|min:0',
            'nombre_pieces' => 'required|integer|min:0',
            'nombre_chambres' => 'required|integer|min:0',
            'nombre_salles_bain' => 'required|integer|min:0',
            'prix_location' => 'required|numeric|min:0',
            'frequence_location' => 'required|in:quotidien,hebdomadaire,mensuel,annuel',
            'depot_garantie' => 'nullable|numeric|min:0',
            'avance' => 'nullable|numeric|min:0',
            'disponibilite' => 'required|in:disponible,loue,reserve,indisponible',
            'statut' => 'required|in:brouillon,en_attente,publie,archive',
            'est_publie' => 'boolean',
            'images.*' => 'nullable|image|max:5120',
            'videos.*' => 'nullable|url',
        ];
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    public function removeExistingImage($id)
    {
        $media = MediaBien::findOrFail($id);
        if (Storage::exists($media->url_media)) {
            Storage::delete($media->url_media);
        }
        $media->delete();
        $this->existingImages = $this->existingImages->filter(function ($img) use ($id) {
            return $img->id != $id;
        });
        session()->flash('success', 'Image supprimée.');
    }

    public function removeVideo($index)
    {
        unset($this->videos[$index]);
        $this->videos = array_values($this->videos);
    }

    public function removeExistingVideo($id)
    {
        $media = MediaBien::findOrFail($id);
        $media->delete();
        $this->existingVideos = $this->existingVideos->filter(function ($vid) use ($id) {
            return $vid->id != $id;
        });
        session()->flash('success', 'Vidéo supprimée.');
    }

    public function save()
    {
        $this->validate();

        // Vérifier que le promoteur est validé
        $promoteur = Promoteur::findOrFail($this->promoteur_id);
        if ($promoteur->statut !== 'VALIDE') {
            session()->flash('error', 'Le promoteur doit être validé pour publier des biens.');
            return;
        }

        $data = [
            'promoteur_id' => $this->promoteur_id,
            'titre' => $this->titre,
            'description' => $this->description,
            'type_bien' => $this->type_bien,
            'adresse' => $this->adresse,
            'ville' => $this->ville,
            'quartier' => $this->quartier,
            'superficie' => $this->superficie,
            'nombre_pieces' => $this->nombre_pieces,
            'nombre_chambres' => $this->nombre_chambres,
            'nombre_salles_bain' => $this->nombre_salles_bain,
            'prix_location' => $this->prix_location,
            'frequence_location' => $this->frequence_location,
            'depot_garantie' => $this->depot_garantie ?? 0,
            'avance' => $this->avance ?? 0,
            'disponibilite' => $this->disponibilite,
            'statut' => $this->statut,
            'est_publie' => $this->est_publie,
        ];

        if ($this->isEdit) {
            $property = Bien::findOrFail($this->propertyId);
            $property->update($data);
            
            if ($this->est_publie && !$property->date_publication) {
                $property->update([
                    'date_publication' => now(),
                    'statut' => 'publie'
                ]);
            }
        } else {
            $data['date_ajout'] = now();
            if ($this->est_publie) {
                $data['date_publication'] = now();
                $data['statut'] = 'publie';
            }
            $property = Bien::create($data);
        }

        // Upload new images
        foreach ($this->images as $image) {
            $path = $image->store('biens', 'public');
            MediaBien::create([
                'bien_id' => $property->id,
                'type_media' => 'IMAGE',
                'url_media' => $path,
                'date_ajout' => now(),
            ]);
        }

        // Add new videos
        foreach ($this->videos as $videoUrl) {
            if (!empty($videoUrl)) {
                MediaBien::create([
                    'bien_id' => $property->id,
                    'type_media' => 'VIDEO',
                    'url_media' => $videoUrl,
                    'date_ajout' => now(),
                ]);
            }
        }

        session()->flash('success', $this->isEdit ? 'Bien modifié avec succès.' : 'Bien créé avec succès.');
        return redirect()->route('admin.properties.show', $property->id);
    }

    public function render()
    {
        $promoteurs = Promoteur::where('statut', 'VALIDE')
            ->with('user')
            ->get();

        return view('livewire.admin.properties.property-form', [
            'promoteurs' => $promoteurs,
        ])->layout('layouts.admin');
    }
}

