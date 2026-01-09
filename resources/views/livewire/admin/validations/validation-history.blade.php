<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-history mr-2"></i>
                        Historique des validations
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.validations.index') }}">Validations</a></li>
                            <li class="breadcrumb-item active">Historique</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.validations.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-md-3">
            <select wire:model.live="filterPromoter" class="form-control">
                <option value="">Tous les promoteurs</option>
                @foreach($promoters as $promoter)
                    <option value="{{ $promoter->id }}">{{ $promoter->user->nom ?? '' }} {{ $promoter->user->prenom ?? '' }} - {{ $promoter->raison_sociale ?? '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select wire:model.live="filterAdmin" class="form-control">
                <option value="">Tous les admins</option>
                @foreach($admins as $admin)
                    <option value="{{ $admin->id }}">{{ $admin->nom ?? '' }} {{ $admin->prenom ?? '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select wire:model.live="filterAction" class="form-control">
                <option value="">Toutes les actions</option>
                @foreach($actions as $action)
                    <option value="{{ $action }}">{{ $action }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" wire:model.live="dateFrom" class="form-control" placeholder="Date début">
        </div>
        <div class="col-md-2">
            <input type="date" wire:model.live="dateTo" class="form-control" placeholder="Date fin">
        </div>
        <div class="col-md-1">
            <button wire:click="$set('filterPromoter', ''); $set('filterAdmin', ''); $set('filterAction', ''); $set('dateFrom', ''); $set('dateTo', '');" 
                    class="btn btn-secondary btn-block">
                <i class="fas fa-redo"></i>
            </button>
        </div>
    </div>

    <!-- History Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Historique des actions de validation
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Promoteur</th>
                                    <th>Action</th>
                                    <th>Statut</th>
                                    <th>Effectuée par</th>
                                    <th>Détails</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($history as $entry)
                                <tr>
                                    <td>{{ $entry->date_action->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <strong>{{ $entry->promoteur->user->nom ?? '' }} {{ $entry->promoteur->user->prenom ?? '' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $entry->promoteur->raison_sociale ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $entry->action }}</span>
                                    </td>
                                    <td>
                                        @if($entry->ancien_statut && $entry->nouveau_statut)
                                            <span class="badge badge-secondary">{{ $entry->ancien_statut }}</span>
                                            <i class="fas fa-arrow-right mx-1"></i>
                                            <span class="badge badge-primary">{{ $entry->nouveau_statut }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $entry->effectuePar->nom ?? '' }} {{ $entry->effectuePar->prenom ?? '' }}</td>
                                    <td>
                                        @if($entry->details)
                                            <small>{{ Str::limit($entry->details, 50) }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Aucun historique trouvé</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $history->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>

