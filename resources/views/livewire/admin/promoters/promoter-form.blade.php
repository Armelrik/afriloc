<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-{{ $isEdit ? 'edit' : 'plus' }} mr-2"></i>
                        {{ $isEdit ? 'Modifier' : 'Créer' }} un promoteur
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.promoters') }}">Promoteurs</a></li>
                            <li class="breadcrumb-item active">{{ $isEdit ? 'Modifier' : 'Créer' }}</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ $isEdit ? route('admin.promoters.show', $promoterId) : route('admin.promoters') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Retour
                </a>
            </div>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <form wire:submit="save">
        <div class="row">
            <div class="col-md-8">
                <!-- Informations utilisateur -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-user mr-2"></i>
                            Informations utilisateur
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nom">Nom <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="nom" class="form-control @error('nom') is-invalid @enderror" id="nom">
                                    @error('nom') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="prenom">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="prenom" class="form-control @error('prenom') is-invalid @enderror" id="prenom">
                                    @error('prenom') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" id="email">
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telephone">Téléphone</label>
                                    <input type="text" wire:model="telephone" class="form-control @error('telephone') is-invalid @enderror" id="telephone">
                                    @error('telephone') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Mot de passe {{ $isEdit ? '(laisser vide pour ne pas modifier)' : '' }} <span class="text-danger">*</span></label>
                                    <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" id="password">
                                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmer le mot de passe <span class="text-danger">*</span></label>
                                    <input type="password" wire:model="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation">
                                    @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations promoteur -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-building mr-2"></i>
                            Informations professionnelles
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="raison_sociale">Raison sociale <span class="text-danger">*</span></label>
                            <input type="text" wire:model="raison_sociale" class="form-control @error('raison_sociale') is-invalid @enderror" id="raison_sociale">
                            @error('raison_sociale') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type_structure">Type de structure <span class="text-danger">*</span></label>
                                    <select wire:model="type_structure" class="form-control @error('type_structure') is-invalid @enderror" id="type_structure">
                                        <option value="">Sélectionner</option>
                                        <option value="SARL">SARL</option>
                                        <option value="SA">SA</option>
                                        <option value="SNC">SNC</option>
                                        <option value="EURL">EURL</option>
                                        <option value="Entreprise individuelle">Entreprise individuelle</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                    @error('type_structure') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="numero_siret">Numéro SIRET</label>
                                    <input type="text" wire:model="numero_siret" class="form-control @error('numero_siret') is-invalid @enderror" id="numero_siret">
                                    @error('numero_siret') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="adresse_professionnelle">Adresse professionnelle <span class="text-danger">*</span></label>
                            <textarea wire:model="adresse_professionnelle" class="form-control @error('adresse_professionnelle') is-invalid @enderror" id="adresse_professionnelle" rows="2"></textarea>
                            @error('adresse_professionnelle') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="ville">Ville <span class="text-danger">*</span></label>
                            <input type="text" wire:model="ville" class="form-control @error('ville') is-invalid @enderror" id="ville">
                            @error('ville') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea wire:model="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="4"></textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
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
                            Statut
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="statut">Statut du promoteur <span class="text-danger">*</span></label>
                            <select wire:model="statut" class="form-control @error('statut') is-invalid @enderror" id="statut">
                                <option value="EN_ATTENTE">En attente</option>
                                <option value="VALIDE">Validé</option>
                                <option value="INCOMPLET">Incomplet</option>
                                <option value="REJETE">Rejeté</option>
                                <option value="SUSPENDU">Suspendu</option>
                            </select>
                            @error('statut') <span class="text-danger">{{ $message }}</span> @enderror
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
                        <a href="{{ $isEdit ? route('admin.promoters.show', $promoterId) : route('admin.promoters') }}" class="btn btn-secondary btn-block">
                            Annuler
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</div>

