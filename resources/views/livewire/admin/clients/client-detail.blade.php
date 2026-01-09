<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-user mr-2"></i>
                        Profil du client
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.clients.index') }}">Clients</a></li>
                            <li class="breadcrumb-item active">Détails</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">
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
        <div class="col-md-4">
            <!-- Profil client -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle mr-2"></i>
                        Informations personnelles
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <span class="text-white" style="font-size: 2rem;">
                                {{ strtoupper(substr($client->user->nom ?? 'C', 0, 1) . substr($client->user->prenom ?? 'L', 0, 1)) }}
                            </span>
                        </div>
                    </div>
                    <p class="text-center"><strong>{{ $client->user->nom ?? '' }} {{ $client->user->prenom ?? '' }}</strong></p>
                    <hr>
                    <p><strong>Email:</strong><br>{{ $client->user->email ?? 'N/A' }}</p>
                    <p><strong>Téléphone:</strong><br>{{ $client->user->telephone ?? 'N/A' }}</p>
                    <p><strong>Adresse:</strong><br>{{ $client->adresse ?? 'N/A' }}</p>
                    <p><strong>Ville:</strong><br>{{ $client->ville_residence ?? 'N/A' }}</p>
                    <p><strong>Date d'inscription:</strong><br>
                    {{ $client->user->date_inscription ? $client->user->date_inscription->format('d/m/Y') : ($client->user->created_at->format('d/m/Y') ?? 'N/A') }}</p>
                    <p><strong>Statut:</strong><br>
                    @if($client->user->est_actif ?? true)
                        <span class="badge badge-success badge-lg">
                            <i class="fas fa-check-circle mr-1"></i>
                            Actif
                        </span>
                    @else
                        <span class="badge badge-danger badge-lg">
                            <i class="fas fa-ban mr-1"></i>
                            Suspendu
                        </span>
                    @endif
                    </p>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Statistiques
                    </h5>
                </div>
                <div class="card-body">
                    <p><strong>Nombre de réservations:</strong><br>
                    <h4>{{ $reservations->count() }}</h4></p>
                    <p><strong>Total dépensé:</strong><br>
                    <h4 class="text-success">{{ number_format($totalDepense, 0, ',', ' ') }} FCFA</h4></p>
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
                    @if($client->user->est_actif ?? true)
                        <button wire:click="suspendre" 
                                class="btn btn-warning btn-block"
                                onclick="return confirm('Êtes-vous sûr de vouloir suspendre ce client ?')">
                            <i class="fas fa-ban mr-1"></i>
                            Suspendre
                        </button>
                    @else
                        <button wire:click="reactiver" 
                                class="btn btn-success btn-block">
                            <i class="fas fa-check mr-1"></i>
                            Réactiver
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Réservations -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-check mr-2"></i>
                        Réservations
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Bien</th>
                                    <th>Dates</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservations as $reservation)
                                <tr>
                                    <td>
                                        <strong>{{ $reservation->bien->titre ?? 'N/A' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $reservation->bien->type_bien ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $reservation->date_debut ? $reservation->date_debut->format('d/m/Y') : 'N/A' }}<br>
                                            <i class="fas fa-arrow-right"></i><br>
                                            {{ $reservation->date_fin ? $reservation->date_fin->format('d/m/Y') : 'N/A' }}
                                        </small>
                                    </td>
                                    <td><strong>{{ number_format($reservation->montant_total ?? 0, 0, ',', ' ') }} FCFA</strong></td>
                                    <td>
                                        @if($reservation->statut == 'CONFIRME')
                                            <span class="badge badge-success">{{ $reservation->statut }}</span>
                                        @elseif($reservation->statut == 'EN_ATTENTE')
                                            <span class="badge badge-warning">{{ $reservation->statut }}</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $reservation->statut ?? 'N/A' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.bookings') }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Aucune réservation</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Historique des paiements -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-money-bill-wave mr-2"></i>
                        Historique des paiements
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Référence</th>
                                    <th>Montant</th>
                                    <th>Méthode</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservations->filter(fn($r) => $r->paiement) as $reservation)
                                    @php $paiement = $reservation->paiement; @endphp
                                <tr>
                                    <td><small>{{ $paiement->reference_transaction ?? $paiement->numero_recu ?? 'N/A' }}</small></td>
                                    <td><strong>{{ number_format($paiement->montant ?? 0, 0, ',', ' ') }} FCFA</strong></td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $paiement->methode_paiement ?? 'N/A')) }}</td>
                                    <td>{{ $paiement->date_paiement ? $paiement->date_paiement->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        @if($paiement->statut == 'VALIDE')
                                            <span class="badge badge-success">{{ $paiement->statut }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ $paiement->statut ?? 'N/A' }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Aucun paiement</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

