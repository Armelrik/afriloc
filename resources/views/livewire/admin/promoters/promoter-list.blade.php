<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <i class="fas fa-user-tie mr-2"></i>
                Gestion des promoteurs
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
            <select wire:model.live="filterStatus" class="form-control">
                <option value="">Tous les promoteurs</option>
                <option value="EN_ATTENTE">En attente d'approbation</option>
                <option value="VALIDE">Validés</option>
                <option value="INCOMPLET">Incomplets</option>
                <option value="REJETE">Rejetés</option>
                <option value="SUSPENDU">Suspendus</option>
            </select>
        </div>
    </div>

    <!-- Promoters Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg animate-on-scroll">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Liste des promoteurs
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="promoters-table" class="table table-bordered table-striped table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Entreprise</th>
                                    <th>Statut</th>
                                    <th>Date d'inscription</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($promoters as $promoter)
                                <tr>
                                    <td>
                                        <strong>{{ $promoter->user->name }}</strong>
                                    </td>
                                    <td>{{ $promoter->user->email }}</td>
                                    <td>{{ $promoter->user->telephone ?? 'N/A' }}</td>
                                    <td>{{ $promoter->raison_sociale ?? 'N/A' }}</td>
                                    <td>
                                        @if ($promoter->statut == 'VALIDE')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Validé
                                            </span>
                                        @elseif ($promoter->statut == 'EN_ATTENTE')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock mr-1"></i>
                                                En attente
                                            </span>
                                        @elseif ($promoter->statut == 'INCOMPLET')
                                            <span class="badge badge-info">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                Incomplet
                                            </span>
                                        @elseif ($promoter->statut == 'REJETE')
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Rejeté
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-ban mr-1"></i>
                                                Suspendu
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $promoter->date_inscription ? $promoter->date_inscription->format('d/m/Y') : $promoter->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if ($promoter->statut == 'EN_ATTENTE')
                                                <button wire:click="approvePromoter({{ $promoter->id }})" 
                                                        class="btn btn-sm btn-success" 
                                                        data-toggle="tooltip" 
                                                        title="Approuver">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @elseif ($promoter->statut == 'VALIDE')
                                                <button wire:click="suspendPromoter({{ $promoter->id }})" 
                                                        class="btn btn-sm btn-warning" 
                                                        data-toggle="tooltip" 
                                                        title="Suspendre">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @endif
                                            <a href="{{ route('admin.promoters.show', $promoter->id) }}" 
                                               class="btn btn-sm btn-info" 
                                               data-toggle="tooltip" 
                                               title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p class="mb-0">Aucun promoteur trouvé</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($promoters->hasPages())
                <div class="card-footer">
                    {{ $promoters->links() }}
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
