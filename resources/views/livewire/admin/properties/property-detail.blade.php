<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-building mr-2"></i>
                        Détails du bien
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.properties') }}">Biens</a></li>
                            <li class="breadcrumb-item active">Détails</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.properties') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Retour à la liste
                    </a>
                    <a href="{{ route('admin.properties.edit', $property->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit mr-1"></i>
                        Modifier
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-8">
            <!-- Informations principales -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informations du bien
                    </h5>
                </div>
                <div class="card-body">
                    <h3 class="mb-3">{{ $property->titre ?? 'N/A' }}</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Type:</strong> {{ ucfirst($property->type_bien ?? 'N/A') }}</p>
                            <p><strong>Superficie:</strong> {{ $property->superficie ?? 0 }} m²</p>
                            <p><strong>Nombre de pièces:</strong> {{ $property->nombre_pieces ?? 0 }}</p>
                            <p><strong>Nombre de chambres:</strong> {{ $property->nombre_chambres ?? 0 }}</p>
                            <p><strong>Nombre de salles de bain:</strong> {{ $property->nombre_salles_bain ?? 0 }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Prix de location:</strong> <h4 class="text-primary">{{ number_format($property->prix_location ?? 0, 0, ',', ' ') }} FCFA</h4></p>
                            <p><strong>Fréquence:</strong> {{ ucfirst($property->frequence_location ?? 'N/A') }}</p>
                            <p><strong>Dépôt de garantie:</strong> {{ number_format($property->depot_garantie ?? 0, 0, ',', ' ') }} FCFA</p>
                            <p><strong>Avance:</strong> {{ number_format($property->avance ?? 0, 0, ',', ' ') }} FCFA</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <p><strong>Adresse:</strong><br>
                            {{ $property->adresse ?? 'N/A' }}, {{ $property->quartier ?? '' }}, {{ $property->ville ?? 'N/A' }}</p>
                            <p><strong>Description:</strong><br>
                            {{ $property->description ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Galerie médias -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-images mr-2"></i>
                        Galerie médias
                    </h5>
                </div>
                <div class="card-body">
                    @if($images->count() > 0)
                        <h6>Images ({{ $images->count() }})</h6>
                        <div class="row">
                            @foreach($images as $image)
                            <div class="col-md-4 mb-3">
                                <a href="{{ $image->public_url }}" target="_blank">
                                    <img src="{{ $image->public_url }}" 
                                         alt="Image" 
                                         class="img-fluid rounded"
                                         style="max-height: 200px; width: 100%; object-fit: cover;">
                                </a>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Aucune image disponible</p>
                    @endif

                    @if($videos->count() > 0)
                        <hr>
                        <h6>Vidéos ({{ $videos->count() }})</h6>
                        <div class="row">
                            @foreach($videos as $video)
                            <div class="col-md-6 mb-3">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="{{ $video->url_media }}" allowfullscreen></iframe>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Réservations -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Réservations ({{ $reservations->count() }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Client</th>
                                    <th>Dates</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservations as $reservation)
                                <tr>
                                    <td>
                                        <strong>{{ $reservation->client->nom ?? '' }} {{ $reservation->client->prenom ?? '' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $reservation->client->email ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $reservation->date_debut ? $reservation->date_debut->format('d/m/Y') : 'N/A' }}<br>
                                            <i class="fas fa-arrow-right"></i><br>
                                            {{ $reservation->date_fin ? $reservation->date_fin->format('d/m/Y') : 'N/A' }}
                                        </small>
                                    </td>
                                    <td><strong>{{ number_format($reservation->montant_total ?? 0, 0, ',', ' ') }} FCFA</strong></td>
                                    <td>
                                        @if($reservation->statut == 'CONFIRME')
                                            <span class="badge badge-success">{{ $reservation->statut }}</span>
                                        @elseif($reservation->statut == 'EN_ATTENTE')
                                            <span class="badge badge-warning">{{ $reservation->statut }}</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $reservation->statut ?? 'N/A' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $reservation->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Aucune réservation</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Statut -->
            <div class="card mb-4">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle mr-2"></i>
                        Statut
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Disponibilité:</strong><br>
                        @if($property->disponibilite == 'disponible')
                            <span class="badge badge-success badge-lg">Disponible</span>
                        @elseif($property->disponibilite == 'loue')
                            <span class="badge badge-danger badge-lg">Loué</span>
                        @elseif($property->disponibilite == 'reserve')
                            <span class="badge badge-warning badge-lg">Réservé</span>
                        @elseif($property->disponibilite == 'indisponible')
                            <span class="badge badge-secondary badge-lg">Indisponible</span>
                        @else
                            <span class="badge badge-warning badge-lg">{{ $property->disponibilite ?? 'N/A' }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <strong>Publication:</strong><br>
                        @if($property->est_publie)
                            <span class="badge badge-success badge-lg">
                                <i class="fas fa-check-circle mr-1"></i>
                                Publié
                            </span>
                            @if($property->date_publication)
                                <br><small class="text-muted">Le {{ $property->date_publication->format('d/m/Y') }}</small>
                            @endif
                        @else
                            <span class="badge badge-secondary badge-lg">
                                <i class="fas fa-times-circle mr-1"></i>
                                Non publié
                            </span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <strong>Statut:</strong><br>
                        @if($property->statut == 'publie')
                            <span class="badge badge-success">Publié</span>
                        @elseif($property->statut == 'brouillon')
                            <span class="badge badge-secondary">Brouillon</span>
                        @elseif($property->statut == 'en_attente')
                            <span class="badge badge-warning">En attente</span>
                        @elseif($property->statut == 'archive')
                            <span class="badge badge-info">Archivé</span>
                        @else
                            <span class="badge badge-secondary">{{ $property->statut ?? 'N/A' }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <strong>Date d'ajout:</strong><br>
                        {{ $property->date_ajout ? $property->date_ajout->format('d/m/Y') : ($property->created_at->format('d/m/Y') ?? 'N/A') }}
                    </div>
                </div>
            </div>

            <!-- Promoteur -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-tie mr-2"></i>
                        Promoteur
                    </h5>
                </div>
                <div class="card-body">
                    <p><strong>Nom:</strong><br>
                    {{ $property->promoteur->user->nom ?? '' }} {{ $property->promoteur->user->prenom ?? '' }}</p>
                    <p><strong>Raison sociale:</strong><br>
                    {{ $property->promoteur->raison_sociale ?? 'N/A' }}</p>
                    <p><strong>Email:</strong><br>
                    {{ $property->promoteur->user->email ?? 'N/A' }}</p>
                    <a href="{{ route('admin.promoters.show', $property->promoteur->id) }}" class="btn btn-sm btn-info btn-block">
                        <i class="fas fa-eye mr-1"></i>
                        Voir le promoteur
                    </a>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cog mr-2"></i>
                        Actions
                    </h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.properties.edit', $property->id) }}" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-edit mr-1"></i>
                        Modifier
                    </a>
                    @if($property->est_publie)
                        <button wire:click="openUnpublishModal" class="btn btn-warning btn-block mb-2">
                            <i class="fas fa-eye-slash mr-1"></i>
                            Dépublier
                        </button>
                    @else
                        <button wire:click="openPublishModal" class="btn btn-success btn-block mb-2">
                            <i class="fas fa-eye mr-1"></i>
                            Publier
                        </button>
                    @endif
                    <button wire:click="openDeleteModal" class="btn btn-danger btn-block">
                        <i class="fas fa-trash mr-1"></i>
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Publish Modal -->
@if($showPublishModal)
<div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-eye mr-2"></i>
                    Publier le bien
                </h5>
                <button type="button" class="close text-white" wire:click="closeModals">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir publier ce bien ?</p>
                <p><strong>{{ $property->titre ?? 'N/A' }}</strong></p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i>
                    Le bien sera visible sur le site public.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Annuler</button>
                <button type="button" class="btn btn-success" wire:click="publish">
                    <i class="fas fa-eye mr-1"></i>
                    Confirmer la publication
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif

<!-- Unpublish Modal -->
@if($showUnpublishModal)
<div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    <i class="fas fa-eye-slash mr-2"></i>
                    Dépublier le bien
                </h5>
                <button type="button" class="close text-white" wire:click="closeModals">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir dépublier ce bien ?</p>
                <p><strong>{{ $property->titre ?? 'N/A' }}</strong></p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Le bien ne sera plus visible sur le site public.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Annuler</button>
                <button type="button" class="btn btn-warning" wire:click="unpublish">
                    <i class="fas fa-eye-slash mr-1"></i>
                    Confirmer la dépublication
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif

<!-- Delete Modal -->
@if($showDeleteModal)
<div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-trash mr-2"></i>
                    Supprimer le bien
                </h5>
                <button type="button" class="close text-white" wire:click="closeModals">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer ce bien ?</p>
                <p><strong>{{ $property->titre ?? 'N/A' }}</strong></p>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Cette action est irréversible. Toutes les réservations associées seront également supprimées.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Annuler</button>
                <button type="button" class="btn btn-danger" wire:click="delete">
                    <i class="fas fa-trash mr-1"></i>
                    Confirmer la suppression
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif
</div>
