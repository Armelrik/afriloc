<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-user-tie mr-2"></i>
                        Détails du promoteur
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.promoters') }}">Promoteurs</a></li>
                            <li class="breadcrumb-item active">Détails</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.promoters') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Retour à la liste
                    </a>
                    <a href="{{ route('admin.promoters.edit', $promoter->id) }}" class="btn btn-primary">
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
        <!-- Informations principales -->
        <div class="col-md-8">
            <!-- Informations promoteur -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-tie mr-2"></i>
                        Informations personnelles
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nom complet:</strong><br>
                            {{ $promoter->user->nom ?? '' }} {{ $promoter->user->prenom ?? '' }}</p>
                            <p><strong>Email:</strong><br>
                            {{ $promoter->user->email ?? 'N/A' }}</p>
                            <p><strong>Téléphone:</strong><br>
                            {{ $promoter->user->telephone ?? 'N/A' }}</p>
                            <p><strong>Date d'inscription:</strong><br>
                            {{ $promoter->date_inscription ? $promoter->date_inscription->format('d/m/Y') : ($promoter->created_at->format('d/m/Y') ?? 'N/A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Raison sociale:</strong><br>
                            {{ $promoter->raison_sociale ?? 'N/A' }}</p>
                            <p><strong>Type de structure:</strong><br>
                            {{ $promoter->type_structure ?? 'N/A' }}</p>
                            <p><strong>Numéro SIRET:</strong><br>
                            {{ $promoter->numero_siret ?? 'N/A' }}</p>
                            <p><strong>Ville:</strong><br>
                            {{ $promoter->ville ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p><strong>Adresse professionnelle:</strong><br>
                            {{ $promoter->adresse_professionnelle ?? 'N/A' }}</p>
                            <p><strong>Description:</strong><br>
                            {{ $promoter->description ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt mr-2"></i>
                        Documents soumis
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6>CNIB Recto</h6>
                            @if($promoter->cnib_recto)
                                <a href="{{ asset('storage/' . $promoter->cnib_recto) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                                @if($promoter->cnib_recto_verifie)
                                    <span class="badge badge-success ml-2">Vérifié</span>
                                @endif
                            @else
                                <span class="text-danger">Non fourni</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>CNIB Verso</h6>
                            @if($promoter->cnib_verso)
                                <a href="{{ asset('storage/' . $promoter->cnib_verso) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                                @if($promoter->cnib_verso_verifie)
                                    <span class="badge badge-success ml-2">Vérifié</span>
                                @endif
                            @else
                                <span class="text-danger">Non fourni</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Photo promoteur</h6>
                            @if($promoter->photo_promoteur)
                                <a href="{{ asset('storage/' . $promoter->photo_promoteur) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                                @if($promoter->photo_verifiee)
                                    <span class="badge badge-success ml-2">Vérifiée</span>
                                @endif
                            @else
                                <span class="text-danger">Non fournie</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Justificatif de domicile</h6>
                            @if($promoter->justificatif_domicile)
                                <a href="{{ asset('storage/' . $promoter->justificatif_domicile) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                                @if($promoter->justificatif_verifie)
                                    <span class="badge badge-success ml-2">Vérifié</span>
                                @endif
                            @else
                                <span class="text-danger">Non fourni</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Registre de commerce</h6>
                            @if($promoter->registre_commerce)
                                <a href="{{ asset('storage/' . $promoter->registre_commerce) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                                @if($promoter->registre_verifie)
                                    <span class="badge badge-success ml-2">Vérifié</span>
                                @endif
                            @else
                                <span class="text-danger">Non fourni</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Attestation fiscale</h6>
                            @if($promoter->attestation_fiscale)
                                <a href="{{ asset('storage/' . $promoter->attestation_fiscale) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                                @if($promoter->attestation_verifiee)
                                    <span class="badge badge-success ml-2">Vérifiée</span>
                                @endif
                            @else
                                <span class="text-danger">Non fournie</span>
                            @endif
                        </div>
                        @if($promoter->certificat_propriete)
                        <div class="col-md-6 mb-3">
                            <h6>Certificat de propriété</h6>
                            <a href="{{ asset('storage/' . $promoter->certificat_propriete) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye mr-1"></i> Voir
                            </a>
                        </div>
                        @endif
                        @if($promoter->assurance_rc)
                        <div class="col-md-6 mb-3">
                            <h6>Assurance RC</h6>
                            <a href="{{ asset('storage/' . $promoter->assurance_rc) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye mr-1"></i> Voir
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Biens du promoteur -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-building mr-2"></i>
                        Biens publiés ({{ $biens->count() }})
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Titre</th>
                                    <th>Type</th>
                                    <th>Prix</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($biens as $bien)
                                <tr>
                                    <td>{{ $bien->titre ?? 'N/A' }}</td>
                                    <td>{{ ucfirst($bien->type_bien ?? 'N/A') }}</td>
                                    <td>{{ number_format($bien->prix_location ?? 0, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        @if($bien->disponibilite == 'DISPONIBLE')
                                            <span class="badge badge-success">Disponible</span>
                                        @else
                                            <span class="badge badge-danger">{{ $bien->disponibilite ?? 'N/A' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.properties.show', $bien->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Aucun bien publié</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Historique -->
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-history mr-2"></i>
                        Historique des actions
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($historique as $entry)
                    <div class="timeline-item mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ $entry->action }}</strong>
                                @if($entry->ancien_statut && $entry->nouveau_statut)
                                    <br>
                                    <small class="text-muted">
                                        {{ $entry->ancien_statut }} → {{ $entry->nouveau_statut }}
                                    </small>
                                @endif
                                @if($entry->details)
                                    <br>
                                    <p class="mb-0 mt-1">{{ $entry->details }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <small class="text-muted">
                                    {{ $entry->date_action->format('d/m/Y H:i') }}
                                    <br>
                                    Par: {{ $entry->effectuePar->nom ?? '' }} {{ $entry->effectuePar->prenom ?? '' }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">Aucun historique disponible</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Statut et score -->
            <div class="card mb-4">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle mr-2"></i>
                        Statut du promoteur
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Statut:</strong><br>
                        @if ($promoter->statut == 'VALIDE')
                            <span class="badge badge-success badge-lg">
                                <i class="fas fa-check-circle mr-1"></i>
                                Validé
                            </span>
                        @elseif ($promoter->statut == 'EN_ATTENTE')
                            <span class="badge badge-warning badge-lg">
                                <i class="fas fa-clock mr-1"></i>
                                En attente
                            </span>
                        @elseif ($promoter->statut == 'INCOMPLET')
                            <span class="badge badge-info badge-lg">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Incomplet
                            </span>
                        @elseif ($promoter->statut == 'REJETE')
                            <span class="badge badge-danger badge-lg">
                                <i class="fas fa-times-circle mr-1"></i>
                                Rejeté
                            </span>
                        @else
                            <span class="badge badge-secondary badge-lg">
                                <i class="fas fa-ban mr-1"></i>
                                Suspendu
                            </span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <strong>Score de complétude:</strong>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar {{ $scoreCompletude >= 100 ? 'bg-success' : ($scoreCompletude >= 70 ? 'bg-warning' : 'bg-danger') }}" 
                                 role="progressbar" 
                                 style="width: {{ $scoreCompletude }}%"
                                 aria-valuenow="{{ $scoreCompletude }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                                {{ $scoreCompletude }}%
                            </div>
                        </div>
                    </div>
                    @if($promoter->date_validation)
                    <div class="mb-3">
                        <strong>Date de validation:</strong><br>
                        {{ $promoter->date_validation->format('d/m/Y H:i') }}
                    </div>
                    @endif
                    @if($promoter->validePar)
                    <div class="mb-3">
                        <strong>Validé par:</strong><br>
                        {{ $promoter->validePar->nom ?? '' }} {{ $promoter->validePar->prenom ?? '' }}
                    </div>
                    @endif
                    @if($promoter->motif_rejet)
                    <div class="mb-3">
                        <strong>Motif de rejet:</strong><br>
                        <p class="text-danger">{{ $promoter->motif_rejet }}</p>
                    </div>
                    @endif
                    @if($promoter->commentaires_validation)
                    <div class="mb-3">
                        <strong>Commentaires:</strong><br>
                        <p>{{ $promoter->commentaires_validation }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Statistiques -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Statistiques
                    </h5>
                </div>
                <div class="card-body">
                    <p><strong>Nombre de biens:</strong><br>
                    <h4>{{ $biens->count() }}</h4></p>
                    <p><strong>Demande de validation:</strong><br>
                    @if($promoter->demandeValidation)
                        <a href="{{ route('admin.validations.show', $promoter->demandeValidation->id) }}" class="btn btn-sm btn-info">
                            Voir la demande
                        </a>
                    @else
                        <span class="text-muted">Aucune demande</span>
                    @endif
                    </p>
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
                    <a href="{{ route('admin.promoters.edit', $promoter->id) }}" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-edit mr-1"></i>
                        Modifier
                    </a>
                    @if($promoter->statut == 'VALIDE')
                        <button wire:click="openSuspendModal" class="btn btn-warning btn-block mb-2">
                            <i class="fas fa-ban mr-1"></i>
                            Suspendre
                        </button>
                    @elseif($promoter->statut == 'SUSPENDU')
                        <button wire:click="openActivateModal" class="btn btn-success btn-block mb-2">
                            <i class="fas fa-check mr-1"></i>
                            Réactiver
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

<!-- Suspend Modal -->
@if($showSuspendModal)
<div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    <i class="fas fa-ban mr-2"></i>
                    Suspendre le promoteur
                </h5>
                <button type="button" class="close text-white" wire:click="closeModals">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir suspendre ce promoteur ?</p>
                <p><strong>{{ $promoter->user->nom ?? '' }} {{ $promoter->user->prenom ?? '' }}</strong></p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Le promoteur ne pourra plus publier de nouveaux biens jusqu'à sa réactivation.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Annuler</button>
                <button type="button" class="btn btn-warning" wire:click="suspend">
                    <i class="fas fa-ban mr-1"></i>
                    Confirmer la suspension
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif

<!-- Activate Modal -->
@if($showActivateModal)
<div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check mr-2"></i>
                    Réactiver le promoteur
                </h5>
                <button type="button" class="close text-white" wire:click="closeModals">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir réactiver ce promoteur ?</p>
                <p><strong>{{ $promoter->user->nom ?? '' }} {{ $promoter->user->prenom ?? '' }}</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Annuler</button>
                <button type="button" class="btn btn-success" wire:click="activate">
                    <i class="fas fa-check mr-1"></i>
                    Confirmer la réactivation
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
                    Supprimer le promoteur
                </h5>
                <button type="button" class="close text-white" wire:click="closeModals">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer ce promoteur ?</p>
                <p><strong>{{ $promoter->user->nom ?? '' }} {{ $promoter->user->prenom ?? '' }}</strong></p>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Cette action est irréversible. Tous les biens associés seront également supprimés.
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

