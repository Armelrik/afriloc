<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-{{ $isEdit ? 'edit' : 'plus' }} mr-2"></i>
                        {{ $isEdit ? 'Modifier' : 'Créer' }} une réservation
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.bookings') }}">Réservations</a></li>
                            <li class="breadcrumb-item active">{{ $isEdit ? 'Modifier' : 'Créer' }}</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ $isEdit ? route('admin.bookings.show', $bookingId) : route('admin.bookings') }}" class="btn btn-secondary">
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
                <!-- Informations de base -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle mr-2"></i>
                            Informations de base
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_id">Client <span class="text-danger">*</span></label>
                                    <select wire:model="client_id" class="form-control @error('client_id') is-invalid @enderror" id="client_id">
                                        <option value="">Sélectionner un client</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">
                                                {{ $client->nom ?? '' }} {{ $client->prenom ?? '' }} - {{ $client->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('client_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bien_id">Bien <span class="text-danger">*</span></label>
                                    <select wire:model="bien_id" class="form-control @error('bien_id') is-invalid @enderror" id="bien_id">
                                        <option value="">Sélectionner un bien</option>
                                        @foreach($biens as $bien)
                                            <option value="{{ $bien->id }}">
                                                {{ $bien->titre }} - {{ number_format($bien->prix_location ?? 0, 0, ',', ' ') }} FCFA
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('bien_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date_debut">Date de début <span class="text-danger">*</span></label>
                                    <input type="date" wire:model="date_debut" class="form-control @error('date_debut') is-invalid @enderror" id="date_debut">
                                    @error('date_debut') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date_fin">Date de fin <span class="text-danger">*</span></label>
                                    <input type="date" wire:model="date_fin" class="form-control @error('date_fin') is-invalid @enderror" id="date_fin">
                                    @error('date_fin') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre_personnes">Nombre de personnes <span class="text-danger">*</span></label>
                                    <input type="number" wire:model="nombre_personnes" class="form-control @error('nombre_personnes') is-invalid @enderror" id="nombre_personnes" min="1">
                                    @error('nombre_personnes') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="montant_total">Montant total (FCFA) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" wire:model="montant_total" class="form-control @error('montant_total') is-invalid @enderror" id="montant_total" min="0">
                            @error('montant_total') <span class="text-danger">{{ $message }}</span> @enderror
                            <small class="form-text text-muted">Le montant sera calculé automatiquement si vous sélectionnez un bien et des dates</small>
                        </div>
                        <div class="form-group">
                            <label for="commentaires">Commentaires</label>
                            <textarea wire:model="commentaires" class="form-control @error('commentaires') is-invalid @enderror" id="commentaires" rows="3"></textarea>
                            @error('commentaires') <span class="text-danger">{{ $message }}</span> @enderror
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
                            <label for="statut">Statut de la réservation <span class="text-danger">*</span></label>
                            <select wire:model="statut" class="form-control @error('statut') is-invalid @enderror" id="statut">
                                <option value="EN_ATTENTE">En attente</option>
                                <option value="CONFIRME">Confirmée</option>
                                <option value="ANNULE">Annulée</option>
                                <option value="TERMINE">Terminée</option>
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
                        <a href="{{ $isEdit ? route('admin.bookings.show', $bookingId) : route('admin.bookings') }}" class="btn btn-secondary btn-block">
                            Annuler
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</div>

