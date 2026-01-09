<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <i class="fas fa-money-bill-wave mr-2"></i>
                Gestion des commissions
            </h1>
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

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total commissions</h5>
                    <h3>{{ number_format($totalCommissions, 0, ',', ' ') }} FCFA</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Transférées</h5>
                    <h3>{{ number_format($totalTransfere, 0, ',', ' ') }} FCFA</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">En attente</h5>
                    <h3>{{ number_format($totalEnAttente, 0, ',', ' ') }} FCFA</h3>
                    <small>{{ $countEnAttente }} commission(s)</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total promoteurs</h5>
                    <h3>{{ number_format($totalPromoteur, 0, ',', ' ') }} FCFA</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-md-3">
            <select wire:model.live="filterTransfere" class="form-control">
                <option value="">Toutes les commissions</option>
                <option value="0">En attente de transfert</option>
                <option value="1">Transférées</option>
            </select>
        </div>
        <div class="col-md-6">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Rechercher par promoteur ou référence paiement...">
        </div>
    </div>

    <!-- Commissions Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Liste des commissions
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Promoteur</th>
                                    <th>Paiement</th>
                                    <th>Montant total</th>
                                    <th>Commission plateforme</th>
                                    <th>Montant promoteur</th>
                                    <th>Date calcul</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($commissions as $commission)
                                <tr>
                                    <td>
                                        <strong>{{ $commission->promoteur->raison_sociale ?? 'N/A' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $commission->promoteur->user->nom ?? '' }} {{ $commission->promoteur->user->prenom ?? '' }}</small>
                                    </td>
                                    <td>
                                        <small>Ref: {{ $commission->paiement->reference_transaction ?? 'N/A' }}</small>
                                        <br>
                                        <small class="text-muted">Bien: {{ $commission->paiement->reservation->bien->titre ?? 'N/A' }}</small>
                                    </td>
                                    <td><strong>{{ number_format($commission->paiement->montant ?? 0, 0, ',', ' ') }} FCFA</strong></td>
                                    <td>
                                        <span class="text-danger">
                                            {{ number_format($commission->montant_commission, 0, ',', ' ') }} FCFA
                                        </span>
                                        <br>
                                        <small class="text-muted">({{ $commission->pourcentage_plateforme }}%)</small>
                                    </td>
                                    <td>
                                        <span class="text-success">
                                            {{ number_format($commission->montant_promoteur, 0, ',', ' ') }} FCFA
                                        </span>
                                    </td>
                                    <td>{{ $commission->date_calcul->format('d/m/Y') }}</td>
                                    <td>
                                        @if($commission->est_transfere)
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Transférée
                                            </span>
                                            @if($commission->date_transfert)
                                                <br><small class="text-muted">{{ $commission->date_transfert->format('d/m/Y') }}</small>
                                            @endif
                                        @else
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock mr-1"></i>
                                                En attente
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.commissions.show', $commission->id) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(!$commission->est_transfere)
                                                <button wire:click="transferer({{ $commission->id }})" 
                                                        class="btn btn-sm btn-success" 
                                                        title="Transférer"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir transférer cette commission au promoteur ?')">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Aucune commission trouvée</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $commissions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>

