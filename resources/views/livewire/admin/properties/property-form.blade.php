<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-{{ $isEdit ? 'edit' : 'plus' }} mr-2"></i>
                        {{ __('messages.admin.properties') }} - {{ $isEdit ? 'Modifier' : 'Créer' }}
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.properties') }}">{{ __('messages.admin.properties') }}</a></li>
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

    <!-- Error Display -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5 class="alert-heading">
                <i class="fas fa-exclamation-circle mr-2"></i>
                Erreurs de validation
            </h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <form wire:submit="save" novalidate>
        <div class="row">
            <div class="col-md-8">
                <!-- Informations de base -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle mr-2"></i>
                            Informations de base
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="promoteur_id">Promoteur <span class="text-danger">*</span></label>
                            <select wire:model.live="promoteur_id" class="form-control @error('promoteur_id') is-invalid @enderror" id="promoteur_id">
                                <option value="">-- Sélectionner un promoteur validé --</option>
                                @foreach($promoteurs as $promoteur)
                                    <option value="{{ $promoteur->id }}">
                                        {{ $promoteur->raison_sociale }} ({{ $promoteur->user->name ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('promoteur_id') 
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted">Seuls les promoteurs validés apparaissent dans cette liste</small>
                        </div>

                        <div class="form-group">
                            <label for="titre">Titre <span class="text-danger">*</span></label>
                            <input type="text" wire:model.lazy="titre" class="form-control @error('titre') is-invalid @enderror" 
                                   id="titre" placeholder="Ex: Beau studio au centre-ville">
                            @error('titre') 
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span></label>
                            <textarea wire:model.lazy="description" class="form-control @error('description') is-invalid @enderror" 
                                      id="description" rows="5" placeholder="Décrivez en détail les caractéristiques du bien..."></textarea>
                            @error('description') 
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type_bien">Type de bien <span class="text-danger">*</span></label>
                                    <select wire:model="type_bien" class="form-control @error('type_bien') is-invalid @enderror" id="type_bien">
                                        <option value="">-- Sélectionner --</option>
                                        <option value="maison">🏠 Maison</option>
                                        <option value="appartement">🏢 Appartement</option>
                                        <option value="studio">📐 Studio</option>
                                        <option value="terrain">🌍 Terrain</option>
                                        <option value="bureau">🏛️ Bureau</option>
                                        <option value="local_commercial">🏪 Local commercial</option>
                                        <option value="entrepot">📦 Entrepôt</option>
                                    </select>
                                    @error('type_bien') 
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="superficie">Superficie (m²) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" wire:model.lazy="superficie" 
                                               class="form-control @error('superficie') is-invalid @enderror" 
                                               id="superficie" min="0" placeholder="0.00">
                                        <div class="input-group-append">
                                            <span class="input-group-text">m²</span>
                                        </div>
                                    </div>
                                    @error('superficie') 
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Caractéristiques -->
                <div class="card mb-4 shadow-sm">
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
                                    <input type="number" wire:model.lazy="nombre_pieces" 
                                           class="form-control @error('nombre_pieces') is-invalid @enderror" 
                                           id="nombre_pieces" min="0" placeholder="0">
                                    @error('nombre_pieces') 
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre_chambres">Chambres <span class="text-danger">*</span></label>
                                    <input type="number" wire:model.lazy="nombre_chambres" 
                                           class="form-control @error('nombre_chambres') is-invalid @enderror" 
                                           id="nombre_chambres" min="0" placeholder="0">
                                    @error('nombre_chambres') 
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre_salles_bain">Salles de bain <span class="text-danger">*</span></label>
                                    <input type="number" wire:model.lazy="nombre_salles_bain" 
                                           class="form-control @error('nombre_salles_bain') is-invalid @enderror" 
                                           id="nombre_salles_bain" min="0" placeholder="0">
                                    @error('nombre_salles_bain') 
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Localisation -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Localisation
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="adresse">Adresse complète <span class="text-danger">*</span></label>
                            <textarea wire:model.lazy="adresse" class="form-control @error('adresse') is-invalid @enderror" 
                                      id="adresse" rows="2" placeholder="Ex: 123 Rue de la Paix"></textarea>
                            @error('adresse') 
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ville">Ville <span class="text-danger">*</span></label>
                                    <input type="text" wire:model.lazy="ville" 
                                           class="form-control @error('ville') is-invalid @enderror" 
                                           id="ville" placeholder="Ex: Ouagadougou">
                                    @error('ville') 
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quartier">Quartier <span class="badge badge-secondary">Optionnel</span></label>
                                    <input type="text" wire:model.lazy="quartier" 
                                           class="form-control @error('quartier') is-invalid @enderror" 
                                           id="quartier" placeholder="Ex: Hamdallaye">
                                    @error('quartier') 
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Prix -->
                <div class="card mb-4 shadow-sm">
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
                                    <label for="prix_location">Prix de location <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" wire:model.lazy="prix_location" 
                                               class="form-control @error('prix_location') is-invalid @enderror" 
                                               id="prix_location" min="0" placeholder="0.00">
                                        <div class="input-group-append">
                                            <span class="input-group-text">FCFA</span>
                                        </div>
                                    </div>
                                    @error('prix_location') 
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="frequence_location">Fréquence <span class="text-danger">*</span></label>
                                    <select wire:model="frequence_location" 
                                            class="form-control @error('frequence_location') is-invalid @enderror" 
                                            id="frequence_location">
                                        <option value="">-- Sélectionner --</option>
                                        <option value="quotidien">Quotidien (par jour)</option>
                                        <option value="hebdomadaire">Hebdomadaire (par semaine)</option>
                                        <option value="mensuel">Mensuel (par mois)</option>
                                        <option value="annuel">Annuel (par an)</option>
                                    </select>
                                    @error('frequence_location') 
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-light" role="alert">
                            <h6 class="alert-heading">
                                <i class="fas fa-info-circle mr-2"></i>
                                Conditions optionnelles
                            </h6>
                            <p class="mb-0">Les champs ci-dessous sont optionnels mais recommandés pour une meilleure description</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="depot_garantie">Dépôt de garantie <span class="badge badge-secondary">Optionnel</span></label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" wire:model.lazy="depot_garantie" 
                                               class="form-control @error('depot_garantie') is-invalid @enderror" 
                                               id="depot_garantie" min="0" placeholder="0.00">
                                        <div class="input-group-append">
                                            <span class="input-group-text">FCFA</span>
                                        </div>
                                    </div>
                                    @error('depot_garantie') 
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">Montant requis avant l'occupation</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="avance">Avance requise <span class="badge badge-secondary">Optionnel</span></label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" wire:model.lazy="avance" 
                                               class="form-control @error('avance') is-invalid @enderror" 
                                               id="avance" min="0" placeholder="0.00">
                                        <div class="input-group-append">
                                            <span class="input-group-text">FCFA</span>
                                        </div>
                                    </div>
                                    @error('avance') 
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">Montant à payer d'avance</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Médias -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-images mr-2"></i>
                            Médias <span class="badge badge-light">Optionnel</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Images existantes -->
                        @if($existingImages && $existingImages->count() > 0)
                            <h6 class="mb-3">
                                <i class="fas fa-image mr-2 text-info"></i>
                                Images existantes ({{ $existingImages->count() }})
                            </h6>
                            <div class="row mb-4 pb-4 border-bottom">
                                @foreach($existingImages as $image)
                                <div class="col-md-3 mb-3">
                                    <div class="position-relative image-container" style="height: 150px;">
                                        <img src="{{ $image->public_url }}" 
                                             alt="Image" 
                                             class="img-fluid rounded"
                                             style="height: 100%; width: 100%; object-fit: cover;">
                                        <button type="button" 
                                                wire:click="removeExistingImage({{ $image->id }})" 
                                                class="btn btn-sm btn-danger position-absolute" 
                                                style="top: 5px; right: 5px;"
                                                onclick="return confirm('Supprimer cette image ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Nouvelles images -->
                        <div class="form-group">
                            <label for="images">
                                <i class="fas fa-upload mr-2"></i>
                                Ajouter des images <span class="badge badge-secondary">Optionnel</span>
                            </label>
                            <div class="custom-file">
                                <input type="file" wire:model="images" class="custom-file-input @error('images.*') is-invalid @enderror" 
                                       id="images" multiple accept="image/*">
                                <label class="custom-file-label" for="images">Choisir les fichiers...</label>
                            </div>
                            @error('images.*') 
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted d-block mt-2">
                                📌 Formats acceptés: JPG, PNG, GIF (max 5MB chacune)
                            </small>
                        </div>

                        @if($images && count($images) > 0)
                            <h6 class="mt-4 mb-3">
                                <i class="fas fa-eye mr-2 text-success"></i>
                                Aperçu des nouvelles images ({{ count($images) }})
                            </h6>
                            <div class="row">
                                @foreach($images as $index => $image)
                                <div class="col-md-3 mb-3">
                                    <div class="position-relative image-container" style="height: 150px;">
                                        <img src="{{ $image->temporaryUrl() }}" 
                                             alt="Preview" 
                                             class="img-fluid rounded"
                                             style="height: 100%; width: 100%; object-fit: cover;">
                                        <button type="button" 
                                                wire:click="removeImage({{ $index }})" 
                                                class="btn btn-sm btn-danger position-absolute" 
                                                style="top: 5px; right: 5px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Vidéos existantes -->
                        @if($existingVideos && $existingVideos->count() > 0)
                            <hr class="my-4">
                            <h6 class="mb-3">
                                <i class="fas fa-video mr-2 text-danger"></i>
                                Vidéos existantes ({{ $existingVideos->count() }})
                            </h6>
                            <div class="mb-3 pb-3 border-bottom">
                                @foreach($existingVideos as $video)
                                <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                                    <div>
                                        <small class="text-muted">{{ Str::limit($video->url_media, 60) }}</small>
                                    </div>
                                    <button type="button" 
                                            wire:click="removeExistingVideo({{ $video->id }})" 
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Supprimer cette vidéo ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Nouvelles vidéos -->
                        <div class="form-group">
                            <label for="videos">
                                <i class="fas fa-link mr-2"></i>
                                Ajouter des vidéos <span class="badge badge-secondary">Optionnel</span>
                            </label>
                            <small class="form-text text-muted d-block mb-2">
                                🎬 Collez les URLs de vos vidéos YouTube, Vimeo, etc.
                            </small>
                            <div id="video-inputs">
                                @if(isset($videos) && is_array($videos))
                                    @foreach($videos as $index => $video)
                                        <div class="input-group mb-2">
                                            <input type="url" wire:model.lazy="videos.{{ $index }}" 
                                                   class="form-control" 
                                                   placeholder="https://youtube.com/watch?v=...">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-danger" onclick="removeVideoInput(this)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="input-group mb-2">
                                        <input type="url" wire:model.lazy="videos.0" 
                                               class="form-control" 
                                               placeholder="https://youtube.com/watch?v=...">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" onclick="addVideoInput()">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Statut -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-cog mr-2"></i>
                            Statut et publication
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="disponibilite">Disponibilité <span class="text-danger">*</span></label>
                            <select wire:model="disponibilite" 
                                    class="form-control @error('disponibilite') is-invalid @enderror" 
                                    id="disponibilite">
                                <option value="disponible">✅ Disponible</option>
                                <option value="loue">❌ Loué</option>
                                <option value="reserve">⏳ Réservé</option>
                                <option value="indisponible">🚫 Indisponible</option>
                            </select>
                            @error('disponibilite') 
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="statut">Statut <span class="text-danger">*</span></label>
                            <select wire:model="statut" class="form-control @error('statut') is-invalid @enderror" 
                                    id="statut">
                                <option value="brouillon">📝 Brouillon</option>
                                <option value="en_attente">⏳ En attente</option>
                                <option value="publie">✅ Publié</option>
                                <option value="archive">📦 Archivé</option>
                            </select>
                            @error('statut') 
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <small class="form-text text-muted mt-1 d-block">
                                ℹ️ Brouillon: privé | En attente: vérification admin | Publié: visible | Archivé: caché
                            </small>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" wire:model="est_publie" class="custom-control-input" id="est_publie">
                                <label class="custom-control-label" for="est_publie">
                                    <span class="font-weight-bold">Publier immédiatement</span>
                                </label>
                            </div>
                            <small class="form-text text-muted d-block mt-2">
                                Si activé, le bien sera visible sur le site public dès l'enregistrement
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <div class="card mb-4 shadow-sm bg-light">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-list-check mr-2"></i>
                            Résumé
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Titre:</strong> <br><small>{{ $titre ?: '—' }}</small></p>
                        <p class="mb-1"><strong>Type:</strong> <br><small>{{ $type_bien ?: '—' }}</small></p>
                        <p class="mb-1"><strong>Superficie:</strong> <br><small>{{ $superficie ? $superficie . ' m²' : '—' }}</small></p>
                        <p class="mb-1"><strong>Prix:</strong> <br><small>{{ $prix_location ? number_format($prix_location, 0, ',', ' ') . ' FCFA/' . $frequence_location : '—' }}</small></p>
                        <hr>
                        <div class="alert alert-info mb-0" role="alert">
                            <small>
                                <i class="fas fa-info-circle mr-1"></i>
                                Tous les champs marqués d'un <span class="text-danger">*</span> sont obligatoires
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card shadow-sm">
                    <div class="card-body p-2">
                        <button type="submit" class="btn btn-primary btn-block btn-lg font-weight-bold">
                            <i class="fas fa-save mr-2"></i>
                            {{ $isEdit ? 'Mettre à jour' : 'Créer le bien' }}
                        </button>
                        <a href="{{ $isEdit ? route('admin.properties.show', $propertyId) : route('admin.properties') }}" 
                           class="btn btn-secondary btn-block mt-2">
                            <i class="fas fa-times mr-1"></i>
                            Annuler
                        </a>
                    </div>
                </div>

                <!-- Help -->
                <div class="card mt-4 bg-info text-white">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="fas fa-question-circle mr-2"></i>
                            Aide
                        </h6>
                        <ul class="mb-0 small">
                            <li>Remplissez d'abord les champs obligatoires</li>
                            <li>Ajoutez des images pour plus d'attractivité</li>
                            <li>Soyez précis dans la description</li>
                            <li>Vérifiez avant de publier</li>
                        </ul>
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
    const container = document.getElementById('video-inputs');
    const newInput = document.createElement('div');
    newInput.className = 'input-group mb-2';
    newInput.innerHTML = `
        <input type="url" class="form-control" placeholder="https://youtube.com/watch?v=...">
        <div class="input-group-append">
            <button type="button" class="btn btn-outline-danger" onclick="removeVideoInput(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    container.appendChild(newInput);
}

function removeVideoInput(btn) {
    btn.closest('.input-group').remove();
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endpush


