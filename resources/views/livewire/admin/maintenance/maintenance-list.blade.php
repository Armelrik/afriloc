<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <i class="fas fa-tools mr-2"></i>
                Gestion de la maintenance
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
                <option value="in_progress">En cours</option>
                <option value="completed">Terminé</option>
                <option value="cancelled">Annulé</option>
            </select>
        </div>
        <div class="col-md-3">
            <select wire:model.live="priorityFilter" class="form-control">
                <option value="">Toutes les priorités</option>
                <option value="low">Basse</option>
                <option value="medium">Moyenne</option>
                <option value="high">Haute</option>
                <option value="urgent">Urgente</option>
            </select>
        </div>
    </div>

    <!-- Maintenance Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg animate-on-scroll">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Demandes de maintenance
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="maintenance-table" class="table table-bordered table-striped table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Titre</th>
                                    <th>Propriété</th>
                                    <th>Client</th>
                                    <th>Catégorie</th>
                                    <th>Priorité</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($maintenanceRequests as $request)
                                <tr class="{{ $request->priority == 'urgent' ? 'table-danger' : '' }}">
                                    <td><strong>{{ $request->title }}</strong></td>
                                    <td>
                                        @if($request->property)
                                            <a href="{{ route('properties.show', $request->property->id) }}" target="_blank">
                                                {{ $request->property->title }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $request->user->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ ucfirst($request->category) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($request->priority == 'urgent')
                                            <span class="badge badge-danger">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                Urgent
                                            </span>
                                        @elseif($request->priority == 'high')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-arrow-up mr-1"></i>
                                                Haute
                                            </span>
                                        @elseif($request->priority == 'medium')
                                            <span class="badge badge-info">
                                                <i class="fas fa-minus mr-1"></i>
                                                Moyenne
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-arrow-down mr-1"></i>
                                                Basse
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($request->status == 'completed')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Terminé
                                            </span>
                                        @elseif($request->status == 'in_progress')
                                            <span class="badge badge-info">
                                                <i class="fas fa-spinner mr-1"></i>
                                                En cours
                                            </span>
                                        @elseif($request->status == 'pending')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock mr-1"></i>
                                                En attente
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="fas fa-ban mr-1"></i>
                                                Annulé
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button wire:click="viewDetails({{ $request->id }})" 
                                                    class="btn btn-sm btn-info" 
                                                    data-toggle="tooltip" 
                                                    title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if($request->status == 'pending')
                                                <button wire:click="markInProgress({{ $request->id }})" 
                                                        class="btn btn-sm btn-primary" 
                                                        data-toggle="tooltip" 
                                                        title="Mettre en cours">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            @endif
                                            @if($request->status == 'in_progress')
                                                <button wire:click="markCompleted({{ $request->id }})" 
                                                        class="btn btn-sm btn-success" 
                                                        data-toggle="tooltip" 
                                                        title="Marquer terminé">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p class="mb-0">Aucune demande de maintenance trouvée</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($maintenanceRequests->hasPages())
                <div class="card-footer">
                    {{ $maintenanceRequests->links() }}
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
