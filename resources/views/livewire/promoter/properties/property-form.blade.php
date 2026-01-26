<div>
    @livewire('components.header')

    <div class="container-fluid" style="background-color: #f8f9fa; min-height: 100vh; padding: 30px 0;">
        <div class="container py-4">
            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-0">
                                <i class="fas fa-{{ $propertyId ? 'edit' : 'plus' }} mr-2"></i>
                                {{ __('messages.properties.my_properties') }} - {{ $propertyId ? __('Modifier') : __('Créer') }}
                            </h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('promoter.dashboard') }}">{{ __('messages.dashboard') ?? 'Accueil' }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('promoter.properties') }}">{{ __('messages.properties.my_properties') }}</a></li>
                                    <li class="breadcrumb-item active">{{ $propertyId ? 'Modifier' : 'Créer' }}</li>
                                </ol>
                            </nav>
                        </div>
                        <a href="{{ route('promoter.properties') }}" class="btn btn-secondary">
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

            <form wire:submit.prevent="save" novalidate>
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
                                    <label for="titre">Titre <span class="text-danger">*</span></label>
                                    <input type="text" wire:model.lazy="titre" 
                                           class="form-control @error('titre') is-invalid @enderror" 
                                           id="titre" placeholder="Titre du bien...">
                                    @error('titre') 
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Description <span class="text-danger">*</span></label>
                                    <textarea wire:model.lazy="description" 
                                              class="form-control @error('description') is-invalid @enderror" 
                                              id="description" rows="4" placeholder="Décrivez en détail votre bien..."></textarea>
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
                                                <option value="villa">🏡 Villa</option>
                                                <option value="terrain">🌍 Terrain</option>
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nombre_pieces">Pièces <span class="text-danger">*</span></label>
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
                                    <textarea wire:model.lazy="adresse" 
                                              class="form-control @error('adresse') is-invalid @enderror" 
                                              id="adresse" rows="2" placeholder="Adresse complète..."></textarea>
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
                                    <p class="mb-0">Les champs ci-dessous sont optionnels mais recommandés</p>
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
                    </div>

                    <!-- Sidebar -->
                    <div class="col-md-4">
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
                                    {{ $propertyId ? 'Mettre à jour' : 'Créer le bien' }}
                                </button>
                                <a href="{{ route('promoter.properties') }}" class="btn btn-secondary btn-block mt-2">
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
                                    <li>Soyez précis dans la description</li>
                                    <li>Indiquez un bon prix</li>
                                    <li>Vérifiez avant de publier</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @livewire('components.footer')
</div>
            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-0">
                                <i class="fas fa-{{ $propertyId ? 'edit' : 'plus' }} mr-2"></i>
                                {{ __('messages.properties.my_properties') }} - {{ $propertyId ? __('Modifier') : __('Créer') }}
                            </h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('promoter.dashboard') }}">{{ __('messages.dashboard') ?? 'Accueil' }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('promoter.properties') }}">{{ __('messages.properties.my_properties') }}</a></li>
                                    <li class="breadcrumb-item active">{{ $propertyId ? 'Modifier' : 'Créer' }}</li>
                                </ol>
                            </nav>
                        </div>
                        <a href="{{ route('promoter.properties') }}" class="btn btn-secondary">
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

            <form wire:submit.prevent="save" novalidate>
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
                                    <label for="titre">Titre <span class="text-danger">*</span></label>
                                    <input type="text" wire:model.lazy="titre" 
                                           class="form-control @error('titre') is-invalid @enderror" 
                                           id="titre" placeholder="Titre du bien...">
                                    @error('titre') 
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description_fr">Description <span class="text-danger">*</span></label>
                                    <textarea wire:model.lazy="description" 
                                              class="form-control @error('description') is-invalid @enderror" 
                                              id="description" rows="4" placeholder="Décrivez en détail votre bien..."></textarea>
                                    @error('description') 
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="type">Type de bien <span class="text-danger">*</span></label>
                                            <select wire:model="type" class="form-control @error('type') is-invalid @enderror" id="type">
                                                <option value="">-- Sélectionner --</option>
                                                <option value="maison">🏠 Maison</option>
                                                <option value="appartement">🏢 Appartement</option>
                                                <option value="studio">📐 Studio</option>
                                                <option value="villa">🏡 Villa</option>
                                                <option value="terrain">🌍 Terrain</option>
                                            </select>
                                            @error('type') 
                                                <div class="invalid-feedback d-block">
                                                    <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                                </div>_bien">Type de bien <span class="text-danger">*</span></label>
                                            <select wire:model="type_bien" class="form-control @error('type_bien') is-invalid @enderror" id="type_bien">
                                                <option value="">-- Sélectionner --</option>
                                                <option value="maison">🏠 Maison</option>
                                                <option value="appartement">🏢 Appartement</option>
                                                <option value="studio">📐 Studio</option>
                                                <option value="villa">🏡 Villa</option>
                                                <option value="terrain">🌍 Terrain</option>
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
                                            @error('superficie>
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
                                            <label for="bedrooms">Chambres <span class="text-danger">*</span></label>
                                            <input type="number" wire:model.lazy="bedrooms" 
                                                   class="form-control @error('bedrooms') is-invalid @enderror" 
                                                   id="bedrooms" min="0" placeholder="0">
                                            @error('bedrooms') 
                                                <div class="invalid-feedback d-block">
                                                    <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="formnombre_chambres">Chambres <span class="text-danger">*</span></label>
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nombre_pieces">Pièces <span class="text-danger">*</span></label>
                                            <input type="number" wire:model.lazy="nombre_pieces" 
                                                   class="form-control @error('nombre_pieces') is-invalid @enderror" 
                                                   id="nombre_pieces" min="0" placeholder="0">
                                            @error('nombre_pieces') 
                                                <div class="invalid-feedback d-block">
                                                    <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="address">Adresse complète <span class="text-danger">*</span></label>
                                    <textarea wire:model.lazy="address" 
                                              class="form-control @error('address') is-invalid @enderror" 
                                              id="address" rows="2" placeholder="Adresse complète..."></textarea>
                                    @error('address') 
                                        <div class="invalid-feedback d-block">
                                            <i claresse">Adresse complète <span class="text-danger">*</span></label>
                                    <textarea wire:model.lazy="adresse" 
                                              class="form-control @error('adresse') is-invalid @enderror" 
                                              id="adresse" rows="2" placeholder="Adresse complète..."></textarea>
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
                                            @error('quartier
                                </div>
                            </div>
                        </div>

                        <!-- Prix -->
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-warning text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-dollar-sign mr-2"></i>
                                    Prix et conditionsx_location">Prix de location <span class="text-danger">*</span></label>
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
                                            @error('frequence_locationency">
                                                <option value="">-- Sélectionner --</option>
                                                <option value="daily">Quotidien (par jour)</option>
                                                <option value="weekly">Hebdomadaire (par semaine)</option>
                                                <option value="monthly">Mensuel (par mois)</option>
                                                <option value="yearly">Annuel (par an)</option>
                                            </select>
                                            @error('rental_frequency') 
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
                                    </h6>depot_garantie">Dépôt de garantie <span class="badge badge-secondary">Optionnel</span></label>
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
                                    </div
                                    </div>
                                    @error('advance_payment') 
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">Montant à payer d'avance</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-md-4">
                        <!-- Summary -->
                        <div class="card mb-4 shadow-sm bg-light">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-list-check mr-2"></i>
                                    Résumé
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-1"><strong>Titre:</strong> <br><small>{{ $title_fr ?: '—' }}</small></p>
                                <p class="mb-1"><strong>Type:</strong> <br><small>{{ $type ?: '—' }}</small></p>
                                <p class="mb-1"><strong>Superficie:</strong> <br><small>{{ $area ? $area . ' m²' : '—' }}</small></p>
                                <p class="mb-1"><strong>Prix:</strong> <br><small>{{ $price ? number_format($price, 0, ',', ' ') . ' FCFA/' . $rental_frequency : '—' }}</small></p>
                                <hr>
                                <div class="alert alert-info mb-0" role="alert">
                                    <small>
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Tous les champs marqués d'un <span class="text-danger">*</span> sont obligatoires
                                    </small>
                                </div>re ?: '—' }}</small></p>
                                <p class="mb-1"><strong>Type:</strong> <br><small>{{ $type_bien ?: '—' }}</small></p>
                                <p class="mb-1"><strong>Superficie:</strong> <br><small>{{ $superficie ? $superficie . ' m²' : '—' }}</small></p>
                                <p class="mb-1"><strong>Prix:</strong> <br><small>{{ $prix_location ? number_format($prix_location, 0, ',', ' ') . ' FCFA/' . $frequence_location
                        <!-- Actions -->
                        <div class="card shadow-sm">
                            <div class="card-body p-2">
                                <button type="submit" class="btn btn-primary btn-block btn-lg font-weight-bold">
                                    <i class="fas fa-save mr-2"></i>
                                    {{ $propertyId ? 'Mettre à jour' : 'Créer le bien' }}
                                </button>
                                <a href="{{ route('promoter.properties') }}" class="btn btn-secondary btn-block mt-2">
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
                                    <li>Soyez précis dans la description</li>
                                    <li>Indiquez un bon prix</li>
                                    <li>Vérifiez avant de publier</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @livewire('components.footer')
</div>
