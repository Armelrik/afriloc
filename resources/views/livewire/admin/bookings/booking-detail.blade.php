<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Détails de la réservation #{{ $booking->id }}
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.bookings') }}">Réservations</a></li>
                            <li class="breadcrumb-item active">Détails</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.bookings') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Retour à la liste
                    </a>
                    <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit mr-1"></i>
                        Modifier
                    </a>
                </div>
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

    <div class="row">
        <div class="col-md-8">
            <!-- Informations réservation -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informations de la réservation
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Date de début:</strong><br>
                            {{ $booking->date_debut ? $booking->date_debut->format('d/m/Y') : 'N/A' }}</p>
                            <p><strong>Date de fin:</strong><br>
                            {{ $booking->date_fin ? $booking->date_fin->format('d/m/Y') : 'N/A' }}</p>
                            <p><strong>Durée:</strong><br>
                            {{ $duree }} jour(s)</p>
                            <p><strong>Nombre de personnes:</strong><br>
                            {{ $booking->nombre_personnes ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Montant total:</strong><br>
                            <h4 class="text-primary">{{ number_format($booking->montant_total ?? 0, 0, ',', ' ') }} FCFA</h4></p>
                            <p><strong>Date de réservation:</strong><br>
                            {{ $booking->date_reservation ? $booking->date_reservation->format('d/m/Y H:i') : 'N/A' }}</p>
                            @if($booking->date_confirmation)
                            <p><strong>Date de confirmation:</strong><br>
                            {{ $booking->date_confirmation->format('d/m/Y H:i') }}</p>
                            @endif
                        </div>
                    </div>
                    @if($booking->commentaires)
                    <hr>
                    <p><strong>Commentaires:</strong><br>
                    {{ $booking->commentaires }}</p>
                    @endif
                </div>
            </div>

            <!-- Informations client -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user mr-2"></i>
                        Informations client
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nom:</strong><br>
                            {{ $booking->client->nom ?? '' }} {{ $booking->client->prenom ?? '' }}</p>
                            <p><strong>Email:</strong><br>
                            {{ $booking->client->email ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Téléphone:</strong><br>
                            {{ $booking->client->telephone ?? 'N/A' }}</p>
                            @php
                                $client = \App\Models\Client::where('user_id', $booking->client_id)->first();
                            @endphp
                            @if($client)
                                <a href="{{ route('admin.clients.show', $client->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye mr-1"></i>
                                    Voir le client
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations bien -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-building mr-2"></i>
                        Informations du bien
                    </h5>
                </div>
                <div class="card-body">
                    <h5>{{ $booking->bien->titre ?? 'N/A' }}</h5>
                    <p><strong>Type:</strong> {{ ucfirst($booking->bien->type_bien ?? 'N/A') }}</p>
                    <p><strong>Adresse:</strong> {{ $booking->bien->adresse ?? 'N/A' }}, {{ $booking->bien->ville ?? 'N/A' }}</p>
                    <p><strong>Prix de location:</strong> {{ number_format($booking->bien->prix_location ?? 0, 0, ',', ' ') }} FCFA</p>
                    <p><strong>Promoteur:</strong> {{ $booking->bien->promoteur->raison_sociale ?? 'N/A' }}</p>
                    <a href="{{ route('admin.properties.show', $booking->bien->id) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-eye mr-1"></i>
                        Voir le bien
                    </a>
                </div>
            </div>

            <!-- Paiement -->
            @if($booking->paiement)
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-money-bill-wave mr-2"></i>
                        Informations de paiement
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Référence transaction:</strong><br>
                            {{ $booking->paiement->reference_transaction ?? 'N/A' }}</p>
                            <p><strong>Numéro de reçu:</strong><br>
                            {{ $booking->paiement->numero_recu ?? 'N/A' }}</p>
                            <p><strong>Montant:</strong><br>
                            <h5 class="text-success">{{ number_format($booking->paiement->montant ?? 0, 0, ',', ' ') }} FCFA</h5></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Méthode de paiement:</strong><br>
                            {{ ucfirst(str_replace('_', ' ', $booking->paiement->methode_paiement ?? 'N/A')) }}</p>
                            <p><strong>Statut:</strong><br>
                            @if($booking->paiement->statut == 'VALIDE')
                                <span class="badge badge-success">{{ $booking->paiement->statut }}</span>
                            @elseif($booking->paiement->statut == 'EN_ATTENTE')
                                <span class="badge badge-warning">{{ $booking->paiement->statut }}</span>
                            @else
                                <span class="badge badge-secondary">{{ $booking->paiement->statut ?? 'N/A' }}</span>
                            @endif
                            </p>
                            <p><strong>Date de paiement:</strong><br>
                            {{ $booking->paiement->date_paiement ? $booking->paiement->date_paiement->format('d/m/Y H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                    @if($booking->paiement->paiementMobileMoney)
                    <hr>
                    <h6>Détails Mobile Money</h6>
                    <p><strong>Numéro:</strong> {{ $booking->paiement->paiementMobileMoney->numero_telephone ?? 'N/A' }}</p>
                    <p><strong>Opérateur:</strong> {{ $booking->paiement->paiementMobileMoney->operateur ?? 'N/A' }}</p>
                    @endif
                    @if($booking->paiement->paiementCarte)
                    <hr>
                    <h6>Détails Carte</h6>
                    <p><strong>Derniers chiffres:</strong> ****{{ $booking->paiement->paiementCarte->derniers_chiffres ?? 'N/A' }}</p>
                    <p><strong>Type:</strong> {{ $booking->paiement->paiementCarte->type_carte ?? 'N/A' }}</p>
                    @endif
                    <a href="{{ route('admin.payments.show', $booking->paiement->id) }}" class="btn btn-sm btn-warning mt-2">
                        <i class="fas fa-eye mr-1"></i>
                        Voir le paiement
                    </a>
                </div>
            </div>
            @else
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-money-bill-wave mr-2"></i>
                        Paiement
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Aucun paiement associé à cette réservation.</p>
                </div>
            </div>
            @endif
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
                        <strong>Statut de la réservation:</strong><br>
                        @if($booking->statut == 'CONFIRME')
                            <span class="badge badge-success badge-lg">Confirmée</span>
                        @elseif($booking->statut == 'EN_ATTENTE')
                            <span class="badge badge-warning badge-lg">En attente</span>
                        @elseif($booking->statut == 'ANNULE')
                            <span class="badge badge-danger badge-lg">Annulée</span>
                        @elseif($booking->statut == 'TERMINE')
                            <span class="badge badge-info badge-lg">Terminée</span>
                        @else
                            <span class="badge badge-secondary badge-lg">{{ $booking->statut ?? 'N/A' }}</span>
                        @endif
                    </div>
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
                    <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-edit mr-1"></i>
                        Modifier
                    </a>
                    @if($booking->statut == 'EN_ATTENTE')
                        <button wire:click="confirm" class="btn btn-success btn-block mb-2">
                            <i class="fas fa-check mr-1"></i>
                            Confirmer
                        </button>
                    @endif
                    @if($booking->statut != 'ANNULE')
                        <button wire:click="openCancelModal" class="btn btn-warning btn-block mb-2">
                            <i class="fas fa-times mr-1"></i>
                            Annuler
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

<!-- Cancel Modal -->
@if($showCancelModal)
<div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    <i class="fas fa-times mr-2"></i>
                    Annuler la réservation
                </h5>
                <button type="button" class="close text-white" wire:click="closeModals">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir annuler cette réservation ?</p>
                <p><strong>Réservation #{{ $booking->id }}</strong></p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Cette action est irréversible.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Annuler</button>
                <button type="button" class="btn btn-warning" wire:click="cancel">
                    <i class="fas fa-times mr-1"></i>
                    Confirmer l'annulation
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
                    Supprimer la réservation
                </h5>
                <button type="button" class="close text-white" wire:click="closeModals">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cette réservation ?</p>
                <p><strong>Réservation #{{ $booking->id }}</strong></p>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Cette action est irréversible.
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

