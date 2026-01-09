<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-{{ $isEdit ? 'edit' : 'plus' }} mr-2"></i>
                        {{ $isEdit ? 'Modifier' : 'Créer' }} un bien
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.properties') }}">Biens</a></li>
                            <li class="breadcrumb-item active">{{ $isEdit ? 'Modifier' : 'Créer' }}</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ $isEdit ? route('admin.properties.show', $propertyId) : route('admin.properties') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Retour
                </a>
            </div>
        </div>
    </div>


    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <form wire:submit="save">
        <div class="row">
            <div class="col-md-8">
                <!-- Informations de base -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle mr-2"></i>
                            Informations de base
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="promoteur_id">Promoteur <span class="text-danger">*</span></label>
                            <select wire:model="promoteur_id" class="form-control @error('promoteur_id') is-invalid @enderror" id="promoteur_id">
                                <option value="">Sélectionner un promoteur</option>
                                @foreach($promoteurs as $promoteur)
                                    <option value="{{ $promoteur->id }}">
                                        {{ $promoteur->raison_sociale }} - {{ $promoteur->user->nom ?? '' }} {{ $promoteur->user->prenom ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('promoteur_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="titre">Titre <span class="text-danger">*</span></label>
                            <input type="text" wire:model="titre" class="form-control @error('titre') is-invalid @enderror" id="titre">
                            @error('titre') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span></label>
                            <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="5"></textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type_bien">Type de bien <span class="text-danger">*</span></label>
                                    <select wire:model="type_bien" class="form-control @error('type_bien') is-invalid @enderror" id="type_bien">
                                        <option value="">Sélectionner</option>
                                        <option value="maison">Maison</option>
                                        <option value="appartement">Appartement</option>
                                        <option value="terrain">Terrain</option>
                                        <option value="bureau">Bureau</option>
                                        <option value="local_commercial">Local commercial</option>
                                    </select>
                                    @error('type_bien') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="superficie">Superficie (m²) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" wire:model="superficie" class="form-control @error('superficie') is-invalid @enderror" id="superficie">
                                    @error('superficie') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Caractéristiques -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-home mr-2"></i>
                            Caractéristiques
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre_pieces">Nombre de pièces <span class="text-danger">*</span></label>
                                    <input type="number" wire:model="nombre_pieces" class="form-control @error('nombre_pieces') is-invalid @enderror" id="nombre_pieces" min="0">
                                    @error('nombre_pieces') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre_chambres">Nombre de chambres <span class="text-danger">*</span></label>
                                    <input type="number" wire:model="nombre_chambres" class="form-control @error('nombre_chambres') is-invalid @enderror" id="nombre_chambres" min="0">
                                    @error('nombre_chambres') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre_salles_bain">Nombre de salles de bain <span class="text-danger">*</span></label>
                                    <input type="number" wire:model="nombre_salles_bain" class="form-control @error('nombre_salles_bain') is-invalid @enderror" id="nombre_salles_bain" min="0">
                                    @error('nombre_salles_bain') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Localisation -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Localisation
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="adresse">Adresse <span class="text-danger">*</span></label>
                            <textarea wire:model="adresse" class="form-control @error('adresse') is-invalid @enderror" id="adresse" rows="2"></textarea>
                            @error('adresse') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ville">Ville <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="ville" class="form-control @error('ville') is-invalid @enderror" id="ville">
                                    @error('ville') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quartier">Quartier</label>
                                    <input type="text" wire:model="quartier" class="form-control @error('quartier') is-invalid @enderror" id="quartier">
                                    @error('quartier') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prix -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-dollar-sign mr-2"></i>
                            Prix et conditions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prix_location">Prix de location (FCFA) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" wire:model="prix_location" class="form-control @error('prix_location') is-invalid @enderror" id="prix_location" min="0">
                                    @error('prix_location') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="frequence_location">Fréquence de location <span class="text-danger">*</span></label>
                                    <select wire:model="frequence_location" class="form-control @error('frequence_location') is-invalid @enderror" id="frequence_location">
                                        <option value="quotidien">Quotidien</option>
                                        <option value="hebdomadaire">Hebdomadaire</option>
                                        <option value="mensuel">Mensuel</option>
                                        <option value="annuel">Annuel</option>
                                    </select>
                                    @error('frequence_location') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="depot_garantie">Dépôt de garantie (FCFA)</label>
                                    <input type="number" step="0.01" wire:model="depot_garantie" class="form-control @error('depot_garantie') is-invalid @enderror" id="depot_garantie" min="0">
                                    @error('depot_garantie') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="avance">Avance (FCFA)</label>
                                    <input type="number" step="0.01" wire:model="avance" class="form-control @error('avance') is-invalid @enderror" id="avance" min="0">
                                    @error('avance') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Médias -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-images mr-2"></i>
                            Médias
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Images existantes -->
                        @if($existingImages->count() > 0)
                            <h6>Images existantes</h6>
                            <div class="row mb-3">
                                @foreach($existingImages as $image)
                                <div class="col-md-3 mb-2">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $image->url_media) }}" 
                                             alt="Image" 
                                             class="img-fluid rounded"
                                             style="max-height: 150px; width: 100%; object-fit: cover;">
                                        <button type="button" 
                                                wire:click="removeExistingImage({{ $image->id }})" 
                                                class="btn btn-sm btn-danger position-absolute" 
                                                style="top: 5px; right: 5px;"
                                                onclick="return confirm('Supprimer cette image ?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <hr>
                        @endif

                        <!-- Nouvelles images -->
                        <div class="form-group">
                            <label for="images">Nouvelles images</label>
                            <input type="file" wire:model="images" class="form-control @error('images.*') is-invalid @enderror" id="images" multiple accept="image/*">
                            @error('images.*') <span class="text-danger">{{ $message }}</span> @enderror
                            <small class="form-text text-muted">Vous pouvez sélectionner plusieurs images (max 5MB chacune)</small>
                        </div>

                        @if($images)
                            <div class="row">
                                @foreach($images as $index => $image)
                                <div class="col-md-3 mb-2">
                                    <div class="position-relative">
                                        <img src="{{ $image->temporaryUrl() }}" 
                                             alt="Preview" 
                                             class="img-fluid rounded"
                                             style="max-height: 150px; width: 100%; object-fit: cover;">
                                        <button type="button" 
                                                wire:click="removeImage({{ $index }})" 
                                                class="btn btn-sm btn-danger position-absolute" 
                                                style="top: 5px; right: 5px;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Vidéos existantes -->
                        @if($existingVideos->count() > 0)
                            <hr>
                            <h6>Vidéos existantes</h6>
                            <div class="mb-3">
                                @foreach($existingVideos as $video)
                                <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                                    <span>{{ $video->url_media }}</span>
                                    <button type="button" 
                                            wire:click="removeExistingVideo({{ $video->id }})" 
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Supprimer cette vidéo ?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            <hr>
                        @endif

                        <!-- Nouvelles vidéos -->
                        <div class="form-group">
                            <label for="videos">Nouvelles vidéos (URLs YouTube, Vimeo, etc.)</label>
                            <div id="video-inputs">
                                <div class="input-group mb-2">
                                    <input type="url" wire:model="videos.0" class="form-control" placeholder="URL de la vidéo">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary" onclick="addVideoInput()">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <small class="form-text text-muted">Ajoutez les URLs des vidéos (YouTube, Vimeo, etc.)</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Statut -->
                <div class="card mb-4">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-cog mr-2"></i>
                            Statut et publication
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="disponibilite">Disponibilité <span class="text-danger">*</span></label>
                            <select wire:model="disponibilite" class="form-control @error('disponibilite') is-invalid @enderror" id="disponibilite">
                                <option value="disponible">Disponible</option>
                                <option value="loue">Loué</option>
                                <option value="reserve">Réservé</option>
                                <option value="indisponible">Indisponible</option>
                            </select>
                            @error('disponibilite') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="statut">Statut <span class="text-danger">*</span></label>
                            <select wire:model="statut" class="form-control @error('statut') is-invalid @enderror" id="statut">
                                <option value="brouillon">Brouillon</option>
                                <option value="en_attente">En attente</option>
                                <option value="publie">Publié</option>
                                <option value="archive">Archivé</option>
                            </select>
                            @error('statut') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" wire:model="est_publie" class="custom-control-input" id="est_publie">
                                <label class="custom-control-label" for="est_publie">Publier sur le site</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save mr-1"></i>
                            {{ $isEdit ? 'Mettre à jour' : 'Créer' }}
                        </button>
                        <a href="{{ $isEdit ? route('admin.properties.show', $propertyId) : route('admin.properties') }}" class="btn btn-secondary btn-block">
                            Annuler
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</div>

@push('scripts')
<script>
function addVideoInput() {
    // Cette fonctionnalité peut être ajoutée avec Alpine.js ou JavaScript vanilla
    // Pour l'instant, on peut ajouter manuellement des vidéos
}
</script>
@endpush

