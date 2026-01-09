<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-clipboard-check mr-2"></i>
                        Détails de la demande de validation
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.validations.index') }}">Validations</a></li>
                            <li class="breadcrumb-item active">Détails</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.validations.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Retour à la liste
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

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
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
                        Informations du promoteur
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nom complet:</strong><br>
                            {{ $validation->promoteur->user->nom ?? '' }} {{ $validation->promoteur->user->prenom ?? '' }}</p>
                            <p><strong>Email:</strong><br>
                            {{ $validation->promoteur->user->email ?? 'N/A' }}</p>
                            <p><strong>Téléphone:</strong><br>
                            {{ $validation->promoteur->user->telephone ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Raison sociale:</strong><br>
                            {{ $validation->promoteur->raison_sociale ?? 'N/A' }}</p>
                            <p><strong>Type de structure:</strong><br>
                            {{ $validation->promoteur->type_structure ?? 'N/A' }}</p>
                            <p><strong>Numéro SIRET:</strong><br>
                            {{ $validation->promoteur->numero_siret ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p><strong>Adresse professionnelle:</strong><br>
                            {{ $validation->promoteur->adresse_professionnelle ?? 'N/A' }}, {{ $validation->promoteur->ville ?? 'N/A' }}</p>
                            <p><strong>Description:</strong><br>
                            {{ $validation->promoteur->description ?? 'N/A' }}</p>
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
                            @if($validation->promoteur->cnib_recto)
                                <a href="{{ asset('storage/' . $validation->promoteur->cnib_recto) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                                @if($validation->promoteur->cnib_recto_verifie)
                                    <span class="badge badge-success ml-2">Vérifié</span>
                                @endif
                            @else
                                <span class="text-danger">Non fourni</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>CNIB Verso</h6>
                            @if($validation->promoteur->cnib_verso)
                                <a href="{{ asset('storage/' . $validation->promoteur->cnib_verso) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                                @if($validation->promoteur->cnib_verso_verifie)
                                    <span class="badge badge-success ml-2">Vérifié</span>
                                @endif
                            @else
                                <span class="text-danger">Non fourni</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Photo promoteur</h6>
                            @if($validation->promoteur->photo_promoteur)
                                <a href="{{ asset('storage/' . $validation->promoteur->photo_promoteur) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                                @if($validation->promoteur->photo_verifiee)
                                    <span class="badge badge-success ml-2">Vérifiée</span>
                                @endif
                            @else
                                <span class="text-danger">Non fournie</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Justificatif de domicile</h6>
                            @if($validation->promoteur->justificatif_domicile)
                                <a href="{{ asset('storage/' . $validation->promoteur->justificatif_domicile) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                                @if($validation->promoteur->justificatif_verifie)
                                    <span class="badge badge-success ml-2">Vérifié</span>
                                @endif
                            @else
                                <span class="text-danger">Non fourni</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Registre de commerce</h6>
                            @if($validation->promoteur->registre_commerce)
                                <a href="{{ asset('storage/' . $validation->promoteur->registre_commerce) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                                @if($validation->promoteur->registre_verifie)
                                    <span class="badge badge-success ml-2">Vérifié</span>
                                @endif
                            @else
                                <span class="text-danger">Non fourni</span>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6>Attestation fiscale</h6>
                            @if($validation->promoteur->attestation_fiscale)
                                <a href="{{ asset('storage/' . $validation->promoteur->attestation_fiscale) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                                @if($validation->promoteur->attestation_verifiee)
                                    <span class="badge badge-success ml-2">Vérifiée</span>
                                @endif
                            @else
                                <span class="text-danger">Non fournie</span>
                            @endif
                        </div>
                        @if($validation->promoteur->certificat_propriete)
                        <div class="col-md-6 mb-3">
                            <h6>Certificat de propriété</h6>
                            <a href="{{ asset('storage/' . $validation->promoteur->certificat_propriete) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye mr-1"></i> Voir
                            </a>
                        </div>
                        @endif
                        @if($validation->promoteur->assurance_rc)
                        <div class="col-md-6 mb-3">
                            <h6>Assurance RC</h6>
                            <a href="{{ asset('storage/' . $validation->promoteur->assurance_rc) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye mr-1"></i> Voir
                            </a>
                        </div>
                        @endif
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
                        Statut de la demande
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Statut:</strong><br>
                        @if ($validation->statut == 'VALIDE')
                            <span class="badge badge-success badge-lg">
                                <i class="fas fa-check-circle mr-1"></i>
                                Validée
                            </span>
                        @elseif ($validation->statut == 'EN_ATTENTE')
                            <span class="badge badge-warning badge-lg">
                                <i class="fas fa-clock mr-1"></i>
                                En attente
                            </span>
                        @elseif ($validation->statut == 'INCOMPLET')
                            <span class="badge badge-info badge-lg">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Incomplète
                            </span>
                        @elseif ($validation->statut == 'REJETE')
                            <span class="badge badge-danger badge-lg">
                                <i class="fas fa-times-circle mr-1"></i>
                                Rejetée
                            </span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <strong>Score de complétude:</strong>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar {{ $validation->score_completude >= 100 ? 'bg-success' : ($validation->score_completude >= 70 ? 'bg-warning' : 'bg-danger') }}" 
                                 role="progressbar" 
                                 style="width: {{ $validation->score_completude ?? 0 }}%"
                                 aria-valuenow="{{ $validation->score_completude ?? 0 }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                                {{ $validation->score_completude ?? 0 }}%
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Date de demande:</strong><br>
                        {{ $validation->date_demande ? $validation->date_demande->format('d/m/Y') : 'N/A' }}
                    </div>
                    @if($validation->date_traitement)
                    <div class="mb-3">
                        <strong>Date de traitement:</strong><br>
                        {{ $validation->date_traitement->format('d/m/Y H:i') }}
                    </div>
                    @endif
                    @if($validation->traitePar)
                    <div class="mb-3">
                        <strong>Traitée par:</strong><br>
                        {{ $validation->traitePar->nom ?? '' }} {{ $validation->traitePar->prenom ?? '' }}
                    </div>
                    @endif
                    @if($validation->motif_rejet)
                    <div class="mb-3">
                        <strong>Motif de rejet:</strong><br>
                        <p class="text-danger">{{ $validation->motif_rejet }}</p>
                    </div>
                    @endif
                    @if($validation->commentaires)
                    <div class="mb-3">
                        <strong>Commentaires:</strong><br>
                        <p>{{ $validation->commentaires }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            @if($validation->statut == 'EN_ATTENTE')
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cog mr-2"></i>
                        Actions
                    </h5>
                </div>
                <div class="card-body">
                    <button wire:click="openApproveModal" class="btn btn-success btn-block mb-2">
                        <i class="fas fa-check mr-1"></i>
                        Approuver
                    </button>
                    <button wire:click="openRejectModal" class="btn btn-danger btn-block mb-2">
                        <i class="fas fa-times mr-1"></i>
                        Rejeter
                    </button>
                    <button wire:click="openIncompleteModal" class="btn btn-warning btn-block">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Demander complément
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modals -->
@if($showApproveModal)
@include('livewire.admin.validations.modals')
@endif
@if($showRejectModal)
@include('livewire.admin.validations.modals')
@endif
@if($showIncompleteModal)
@include('livewire.admin.validations.modals')
@endif
</div>

