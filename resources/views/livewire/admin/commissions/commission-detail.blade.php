<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-money-bill-wave mr-2"></i>
                        Détails de la commission
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.commissions.index') }}">Commissions</a></li>
                            <li class="breadcrumb-item active">Détails</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.commissions.index') }}" class="btn btn-secondary">
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

    <div class="row">
        <div class="col-md-8">
            <!-- Informations commission -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informations de la commission
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Montant total du paiement:</strong><br>
                            <h4 class="text-primary">{{ number_format($commission->paiement->montant ?? 0, 0, ',', ' ') }} FCFA</h4></p>
                            <p><strong>Commission plateforme:</strong><br>
                            <h5 class="text-danger">{{ number_format($commission->montant_commission, 0, ',', ' ') }} FCFA ({{ $commission->pourcentage_plateforme }}%)</h5></p>
                            <p><strong>Montant promoteur:</strong><br>
                            <h5 class="text-success">{{ number_format($commission->montant_promoteur, 0, ',', ' ') }} FCFA</h5></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Date de calcul:</strong><br>
                            {{ $commission->date_calcul->format('d/m/Y') }}</p>
                            <p><strong>Statut:</strong><br>
                            @if($commission->est_transfere)
                                <span class="badge badge-success badge-lg">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Transférée
                                </span>
                                @if($commission->date_transfert)
                                    <br><small class="text-muted">Le {{ $commission->date_transfert->format('d/m/Y à H:i') }}</small>
                                @endif
                            @else
                                <span class="badge badge-warning badge-lg">
                                    <i class="fas fa-clock mr-1"></i>
                                    En attente de transfert
                                </span>
                            @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations paiement -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-credit-card mr-2"></i>
                        Informations du paiement
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Référence transaction:</strong><br>
                            {{ $commission->paiement->reference_transaction ?? 'N/A' }}</p>
                            <p><strong>Numéro de reçu:</strong><br>
                            {{ $commission->paiement->numero_recu ?? 'N/A' }}</p>
                            <p><strong>Méthode de paiement:</strong><br>
                            {{ ucfirst(str_replace('_', ' ', $commission->paiement->methode_paiement ?? 'N/A')) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Statut du paiement:</strong><br>
                            @if($commission->paiement->statut == 'VALIDE')
                                <span class="badge badge-success">{{ $commission->paiement->statut }}</span>
                            @else
                                <span class="badge badge-warning">{{ $commission->paiement->statut }}</span>
                            @endif
                            </p>
                            <p><strong>Date de paiement:</strong><br>
                            {{ $commission->paiement->date_paiement ? $commission->paiement->date_paiement->format('d/m/Y H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations bien et client -->
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-building mr-2"></i>
                        Bien et client
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Bien</h6>
                            <p><strong>Titre:</strong> {{ $commission->paiement->reservation->bien->titre ?? 'N/A' }}</p>
                            <p><strong>Type:</strong> {{ $commission->paiement->reservation->bien->type_bien ?? 'N/A' }}</p>
                            <p><strong>Prix location:</strong> {{ number_format($commission->paiement->reservation->bien->prix_location ?? 0, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Client</h6>
                            <p><strong>Nom:</strong> {{ $commission->paiement->reservation->client->nom ?? '' }} {{ $commission->paiement->reservation->client->prenom ?? '' }}</p>
                            <p><strong>Email:</strong> {{ $commission->paiement->reservation->client->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Informations promoteur -->
            <div class="card mb-4">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-tie mr-2"></i>
                        Promoteur
                    </h5>
                </div>
                <div class="card-body">
                    <p><strong>Raison sociale:</strong><br>
                    {{ $commission->promoteur->raison_sociale ?? 'N/A' }}</p>
                    <p><strong>Contact:</strong><br>
                    {{ $commission->promoteur->user->nom ?? '' }} {{ $commission->promoteur->user->prenom ?? '' }}<br>
                    {{ $commission->promoteur->user->email ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Actions -->
            @if(!$commission->est_transfere)
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cog mr-2"></i>
                        Actions
                    </h5>
                </div>
                <div class="card-body">
                    <button wire:click="transferer" 
                            class="btn btn-success btn-block"
                            onclick="return confirm('Êtes-vous sûr de vouloir transférer cette commission au promoteur ?')">
                        <i class="fas fa-paper-plane mr-1"></i>
                        Transférer au promoteur
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</div>

