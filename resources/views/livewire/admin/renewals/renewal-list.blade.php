<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <i class="fas fa-sync-alt mr-2"></i>
                Gestion des renouvellements
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
                <option value="pending">En attente</option>
                <option value="approved">Approuvé</option>
                <option value="rejected">Rejeté</option>
                <option value="cancelled">Annulé</option>
            </select>
        </div>
    </div>

    <!-- Renewals Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg animate-on-scroll">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Liste des renouvellements
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="renewals-table" class="table table-bordered table-striped table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Client</th>
                                    <th>Propriété</th>
                                    <th>Date fin actuelle</th>
                                    <th>Nouvelle période</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($renewals ?? [] as $renewal)
                                <tr>
                                    <td>{{ $renewal->user->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($renewal->property)
                                            <a href="{{ route('properties.show', $renewal->property->id) }}" target="_blank">
                                                {{ $renewal->property->title }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $renewal->current_end_date->format('d/m/Y') }}</td>
                                    <td class="text-nowrap">
                                        <small>
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $renewal->new_start_date->format('d/m/Y') }} <br>
                                            <i class="fas fa-arrow-right mr-1"></i>
                                            {{ $renewal->new_end_date->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <strong>{{ number_format($renewal->renewal_amount, 0, ',', ' ') }} FCFA</strong>
                                    </td>
                                    <td>
                                        @if($renewal->status == 'approved')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Approuvé
                                            </span>
                                        @elseif($renewal->status == 'pending')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock mr-1"></i>
                                                En attente
                                            </span>
                                        @elseif($renewal->status == 'rejected')
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Rejeté
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-ban mr-1"></i>
                                                Annulé
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $renewal->renewal_type == 'automatic' ? 'info' : 'secondary' }}">
                                            {{ ucfirst($renewal->renewal_type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button wire:click="viewDetails({{ $renewal->id }})" 
                                                    class="btn btn-sm btn-info" 
                                                    data-toggle="tooltip" 
                                                    title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if($renewal->status == 'pending')
                                                <button wire:click="approve({{ $renewal->id }})" 
                                                        class="btn btn-sm btn-success" 
                                                        data-toggle="tooltip" 
                                                        title="Approuver">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button wire:click="reject({{ $renewal->id }})" 
                                                        class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Rejeter ce renouvellement ?')"
                                                        data-toggle="tooltip" 
                                                        title="Rejeter">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p class="mb-0">Aucun renouvellement trouvé</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($renewals->hasPages())
                <div class="card-footer">
                    {{ $renewals->links() }}
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
