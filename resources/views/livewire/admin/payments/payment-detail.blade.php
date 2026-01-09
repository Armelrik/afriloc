<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-money-bill-wave mr-2"></i>
                        Détails du paiement #{{ $payment->id }}
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.payments') }}">Paiements</a></li>
                            <li class="breadcrumb-item active">Détails</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.payments') }}" class="btn btn-secondary">
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
            <!-- Informations paiement -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informations du paiement
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Référence transaction:</strong><br>
                            {{ $payment->reference_transaction ?? 'N/A' }}</p>
                            <p><strong>Numéro de reçu:</strong><br>
                            {{ $payment->numero_recu ?? 'N/A' }}</p>
                            <p><strong>Montant:</strong><br>
                            <h4 class="text-success">{{ number_format($payment->montant ?? 0, 0, ',', ' ') }} FCFA</h4></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Méthode de paiement:</strong><br>
                            {{ ucfirst(str_replace('_', ' ', $payment->methode_paiement ?? 'N/A')) }}</p>
                            <p><strong>Date de paiement:</strong><br>
                            {{ $payment->date_paiement ? $payment->date_paiement->format('d/m/Y H:i') : 'N/A' }}</p>
                            <p><strong>Date de création:</strong><br>
                            {{ $payment->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Détails selon méthode -->
            @if($payment->paiementMobileMoney)
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-mobile-alt mr-2"></i>
                        Détails Mobile Money
                    </h5>
                </div>
                <div class="card-body">
                    <p><strong>Numéro de téléphone:</strong><br>
                    {{ $payment->paiementMobileMoney->numero_telephone ?? 'N/A' }}</p>
                    <p><strong>Opérateur:</strong><br>
                    {{ $payment->paiementMobileMoney->operateur ?? 'N/A' }}</p>
                    <p><strong>Code de transaction:</strong><br>
                    {{ $payment->paiementMobileMoney->code_transaction ?? 'N/A' }}</p>
                </div>
            </div>
            @endif

            @if($payment->paiementCarte)
            <div class="card mb-4">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-credit-card mr-2"></i>
                        Détails Carte
                    </h5>
                </div>
                <div class="card-body">
                    <p><strong>Derniers chiffres:</strong><br>
                    ****{{ $payment->paiementCarte->derniers_chiffres ?? 'N/A' }}</p>
                    <p><strong>Type de carte:</strong><br>
                    {{ $payment->paiementCarte->type_carte ?? 'N/A' }}</p>
                    <p><strong>Nom sur la carte:</strong><br>
                    {{ $payment->paiementCarte->nom_titulaire ?? 'N/A' }}</p>
                    <p><strong>Date d'expiration:</strong><br>
                    {{ $payment->paiementCarte->date_expiration ?? 'N/A' }}</p>
                </div>
            </div>
            @endif

            <!-- Réservation associée -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Réservation associée
                    </h5>
                </div>
                <div class="card-body">
                    <p><strong>Réservation #{{ $payment->reservation->id ?? 'N/A' }}</strong></p>
                    <p><strong>Bien:</strong> {{ $payment->reservation->bien->titre ?? 'N/A' }}</p>
                    <p><strong>Client:</strong> {{ $payment->reservation->client->nom ?? '' }} {{ $payment->reservation->client->prenom ?? '' }}</p>
                    <p><strong>Dates:</strong> 
                        {{ $payment->reservation->date_debut ? $payment->reservation->date_debut->format('d/m/Y') : 'N/A' }} 
                        - 
                        {{ $payment->reservation->date_fin ? $payment->reservation->date_fin->format('d/m/Y') : 'N/A' }}
                    </p>
                    <a href="{{ route('admin.bookings.show', $payment->reservation->id) }}" class="btn btn-sm btn-success">
                        <i class="fas fa-eye mr-1"></i>
                        Voir la réservation
                    </a>
                </div>
            </div>

            <!-- Commission -->
            @if($payment->commission)
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-hand-holding-usd mr-2"></i>
                        Commission
                    </h5>
                </div>
                <div class="card-body">
                    <p><strong>Montant commission plateforme:</strong><br>
                    {{ number_format($payment->commission->montant_commission ?? 0, 0, ',', ' ') }} FCFA</p>
                    <p><strong>Montant promoteur:</strong><br>
                    {{ number_format($payment->commission->montant_promoteur ?? 0, 0, ',', ' ') }} FCFA</p>
                    <p><strong>Pourcentage plateforme:</strong><br>
                    {{ $payment->commission->pourcentage_plateforme ?? 0 }}%</p>
                    <p><strong>Statut transfert:</strong><br>
                    @if($payment->commission->est_transfere)
                        <span class="badge badge-success">Transféré</span>
                    @else
                        <span class="badge badge-warning">En attente</span>
                    @endif
                    </p>
                    <a href="{{ route('admin.commissions.show', $payment->commission->id) }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-eye mr-1"></i>
                        Voir la commission
                    </a>
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
                        <strong>Statut du paiement:</strong><br>
                        @if($payment->statut == 'VALIDE')
                            <span class="badge badge-success badge-lg">Validé</span>
                        @elseif($payment->statut == 'EN_ATTENTE')
                            <span class="badge badge-warning badge-lg">En attente</span>
                        @elseif($payment->statut == 'EN_COURS')
                            <span class="badge badge-info badge-lg">En cours</span>
                        @elseif($payment->statut == 'ECHOUE')
                            <span class="badge badge-danger badge-lg">Échoué</span>
                        @elseif($payment->statut == 'REMBOURSE')
                            <span class="badge badge-secondary badge-lg">Remboursé</span>
                        @else
                            <span class="badge badge-secondary badge-lg">{{ $payment->statut ?? 'N/A' }}</span>
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
                    @if($payment->statut == 'EN_ATTENTE' || $payment->statut == 'EN_COURS')
                        <button wire:click="openValidateModal" class="btn btn-success btn-block mb-2">
                            <i class="fas fa-check mr-1"></i>
                            Valider
                        </button>
                        <button wire:click="openFailModal" class="btn btn-danger btn-block mb-2">
                            <i class="fas fa-times mr-1"></i>
                            Marquer comme échoué
                        </button>
                    @endif
                    @if($payment->statut == 'VALIDE')
                        <button wire:click="openRefundModal" class="btn btn-warning btn-block mb-2">
                            <i class="fas fa-undo mr-1"></i>
                            Rembourser
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Validate Modal -->
@if($showValidateModal)
<div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check mr-2"></i>
                    Valider le paiement
                </h5>
                <button type="button" class="close text-white" wire:click="closeModals">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir valider ce paiement ?</p>
                <p><strong>Montant:</strong> {{ number_format($payment->montant ?? 0, 0, ',', ' ') }} FCFA</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Annuler</button>
                <button type="button" class="btn btn-success" wire:click="validatePayment">
                    <i class="fas fa-check mr-1"></i>
                    Confirmer la validation
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif

<!-- Refund Modal -->
@if($showRefundModal)
<div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    <i class="fas fa-undo mr-2"></i>
                    Rembourser le paiement
                </h5>
                <button type="button" class="close text-white" wire:click="closeModals">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir rembourser ce paiement ?</p>
                <p><strong>Montant:</strong> {{ number_format($payment->montant ?? 0, 0, ',', ' ') }} FCFA</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Cette action est irréversible.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Annuler</button>
                <button type="button" class="btn btn-warning" wire:click="refund">
                    <i class="fas fa-undo mr-1"></i>
                    Confirmer le remboursement
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif

<!-- Fail Modal -->
@if($showFailModal)
<div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-times mr-2"></i>
                    Marquer comme échoué
                </h5>
                <button type="button" class="close text-white" wire:click="closeModals">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir marquer ce paiement comme échoué ?</p>
                <p><strong>Montant:</strong> {{ number_format($payment->montant ?? 0, 0, ',', ' ') }} FCFA</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Annuler</button>
                <button type="button" class="btn btn-danger" wire:click="fail">
                    <i class="fas fa-times mr-1"></i>
                    Confirmer
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif
</div>

