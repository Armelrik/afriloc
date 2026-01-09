<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <i class="fas fa-users mr-2"></i>
                Gestion des clients
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
                    <h5 class="card-title">Total clients</h5>
                    <h3>{{ $totalClients }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Clients actifs</h5>
                    <h3>{{ $clientsActifs }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total réservations</h5>
                    <h3>{{ $totalReservations }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Total dépensé</h5>
                    <h3>{{ number_format($totalDepense, 0, ',', ' ') }} FCFA</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-md-3">
            <select wire:model.live="filterVille" class="form-control">
                <option value="">Toutes les villes</option>
                @foreach($villes as $ville)
                    <option value="{{ $ville }}">{{ $ville }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select wire:model.live="filterActif" class="form-control">
                <option value="">Tous les statuts</option>
                <option value="1">Actifs</option>
                <option value="0">Suspendus</option>
            </select>
        </div>
        <div class="col-md-7">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Rechercher par nom, email ou téléphone...">
        </div>
    </div>

    <!-- Clients Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Liste des clients
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nom complet</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Ville</th>
                                    <th>Réservations</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($clients as $client)
                                <tr>
                                    <td>
                                        <strong>{{ $client->user->nom ?? '' }} {{ $client->user->prenom ?? '' }}</strong>
                                    </td>
                                    <td>{{ $client->user->email ?? 'N/A' }}</td>
                                    <td>{{ $client->user->telephone ?? 'N/A' }}</td>
                                    <td>{{ $client->ville_residence ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $client->reservations->count() ?? 0 }}</span>
                                    </td>
                                    <td>
                                        @if($client->user->est_actif ?? true)
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Actif
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="fas fa-ban mr-1"></i>
                                                Suspendu
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.clients.show', $client->id) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($client->user->est_actif ?? true)
                                                <button wire:click="suspendre({{ $client->id }})" 
                                                        class="btn btn-sm btn-warning" 
                                                        title="Suspendre"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir suspendre ce client ?')">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @else
                                                <button wire:click="reactiver({{ $client->id }})" 
                                                        class="btn btn-sm btn-success" 
                                                        title="Réactiver">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Aucun client trouvé</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>

