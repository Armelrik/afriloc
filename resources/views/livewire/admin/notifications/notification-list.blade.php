<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-bell mr-2"></i>
                        Gestion des notifications
                    </h1>
                </div>
                <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i>
                    Envoyer une notification
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

    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-md-2">
            <select wire:model.live="filterType" class="form-control">
                <option value="">Tous les types</option>
                @foreach($types as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select wire:model.live="filterPriorite" class="form-control">
                <option value="">Toutes les priorités</option>
                <option value="URGENTE">Urgente</option>
                <option value="HAUTE">Haute</option>
                <option value="NORMALE">Normale</option>
            </select>
        </div>
        <div class="col-md-2">
            <select wire:model.live="filterStatut" class="form-control">
                <option value="">Tous les statuts</option>
                <option value="0">Non lues</option>
                <option value="1">Lues</option>
            </select>
        </div>
        <div class="col-md-2">
            <select wire:model.live="filterCanal" class="form-control">
                <option value="">Tous les canaux</option>
                @foreach($canaux as $canal)
                    <option value="{{ $canal }}">{{ $canal }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Rechercher par contenu ou utilisateur...">
        </div>
    </div>

    <!-- Notifications Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Liste des notifications
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Type</th>
                                    <th>Contenu</th>
                                    <th>Priorité</th>
                                    <th>Canal</th>
                                    <th>Date envoi</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($notifications as $notification)
                                <tr class="{{ !$notification->est_lue ? 'table-warning' : '' }}">
                                    <td>
                                        <strong>{{ $notification->utilisateur->nom ?? '' }} {{ $notification->utilisateur->prenom ?? '' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $notification->utilisateur->email ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $notification->type ?? 'N/A' }}</span>
                                    </td>
                                    <td>{{ Str::limit($notification->contenu ?? 'N/A', 60) }}</td>
                                    <td>
                                        @if($notification->priorite == 'URGENTE')
                                            <span class="badge badge-danger">{{ $notification->priorite }}</span>
                                        @elseif($notification->priorite == 'HAUTE')
                                            <span class="badge badge-warning">{{ $notification->priorite }}</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $notification->priorite ?? 'NORMALE' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">{{ $notification->canal ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        {{ $notification->date_envoi ? $notification->date_envoi->format('d/m/Y H:i') : 'N/A' }}
                                    </td>
                                    <td>
                                        @if($notification->est_lue)
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Lue
                                            </span>
                                            @if($notification->date_lecture)
                                                <br><small class="text-muted">{{ $notification->date_lecture->format('d/m/Y H:i') }}</small>
                                            @endif
                                        @else
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock mr-1"></i>
                                                Non lue
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if($notification->est_lue)
                                                <button wire:click="marquerCommeNonLue({{ $notification->id }})" 
                                                        class="btn btn-sm btn-warning" 
                                                        title="Marquer comme non lue">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            @else
                                                <button wire:click="marquerCommeLue({{ $notification->id }})" 
                                                        class="btn btn-sm btn-success" 
                                                        title="Marquer comme lue">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Aucune notification trouvée</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>

