<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <i class="fas fa-dollar-sign mr-2"></i>
                Gestion des paiements
            </h1>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-md-3">
            <select wire:model.live="statusFilter" class="form-control">
                <option value="">Tous les statuts</option>
                <option value="EN_ATTENTE">En attente</option>
                <option value="EN_COURS">En traitement</option>
                <option value="VALIDE">Validé</option>
                <option value="ECHOUE">Échoué</option>
                <option value="REMBOURSE">Remboursé</option>
            </select>
        </div>
        <div class="col-md-3">
            <select wire:model.live="methodFilter" class="form-control">
                <option value="">Tous les modes</option>
                <option value="MOBILE_MONEY">Mobile Money</option>
                <option value="CARTE">Carte bancaire</option>
                <option value="ESPECES">Espèces</option>
                <option value="VIREMENT">Virement bancaire</option>
            </select>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg animate-on-scroll">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Liste des paiements
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="payments-table" class="table table-bordered table-striped table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Référence</th>
                                    <th>Client</th>
                                    <th>Réservation</th>
                                    <th>Montant</th>
                                    <th>Mode</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $payment)
                                <tr>
                                    <td>
                                        <code>{{ $payment->reference_transaction ?? $payment->numero_recu ?? 'N/A' }}</code>
                                    </td>
                                    <td>{{ $payment->reservation->client->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($payment->reservation)
                                            <a href="{{ route('admin.bookings') }}">
                                                #{{ $payment->reservation->id }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ number_format($payment->montant ?? 0, 0, ',', ' ') }} FCFA</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ ucfirst(str_replace('_', ' ', $payment->methode_paiement)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($payment->statut == 'VALIDE')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Validé
                                            </span>
                                        @elseif($payment->statut == 'EN_ATTENTE')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock mr-1"></i>
                                                En attente
                                            </span>
                                        @elseif($payment->statut == 'EN_COURS')
                                            <span class="badge badge-info">
                                                <i class="fas fa-spinner mr-1"></i>
                                                En traitement
                                            </span>
                                        @elseif($payment->statut == 'ECHOUE')
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Échoué
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-undo mr-1"></i>
                                                Remboursé
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $payment->date_paiement ? $payment->date_paiement->format('d/m/Y H:i') : $payment->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.payments.show', $payment->id) }}" 
                                               class="btn btn-sm btn-info" 
                                               data-toggle="tooltip" 
                                               title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($payment->statut == 'EN_ATTENTE')
                                                <button wire:click="markAsCompleted({{ $payment->id }})" 
                                                        class="btn btn-sm btn-success" 
                                                        data-toggle="tooltip" 
                                                        title="Valider">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            @if($payment->statut == 'VALIDE')
                                                <button wire:click="refund({{ $payment->id }})" 
                                                        class="btn btn-sm btn-warning" 
                                                        onclick="return confirm('Rembourser ce paiement ?')"
                                                        data-toggle="tooltip" 
                                                        title="Rembourser">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p class="mb-0">Aucun paiement trouvé</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($payments->hasPages())
                <div class="card-footer">
                    {{ $payments->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    initTooltips();
});
</script>
@endpush
