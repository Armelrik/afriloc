<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <i class="fas fa-calendar-check mr-2"></i>
                {{ __('messages.admin.bookings') }}
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
            <input type="text" wire:model.live="search" class="form-control" placeholder="Rechercher...">
        </div>
        <div class="col-md-2">
            <select wire:model.live="statusFilter" class="form-control">
                <option value="">Tous les statuts</option>
                <option value="EN_ATTENTE">En attente</option>
                <option value="CONFIRME">Confirmée</option>
                <option value="ANNULE">Annulée</option>
                <option value="TERMINE">Terminée</option>
            </select>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg animate-on-scroll">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Liste des réservations
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="bookings-table" class="table table-bordered table-striped table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>{{ __('messages.admin.customer') }}</th>
                                    <th>{{ __('messages.admin.property') }}</th>
                                    <th>{{ __('messages.admin.dates') }}</th>
                                    <th>Montant</th>
                                    <th>{{ __('messages.admin.status') }}</th>
                                    <th>{{ __('messages.admin.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $booking->client->name ?? 'N/A' }}</strong>
                                        </div>
                                        <small class="text-muted">{{ $booking->client->email ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        @if($booking->bien)
                                            <a href="#" target="_blank">
                                                {{ $booking->bien->titre }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        <small>
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $booking->date_debut ? $booking->date_debut->format('d/m/Y') : 'N/A' }} <br>
                                            <i class="fas fa-arrow-right mr-1"></i>
                                            {{ $booking->date_fin ? $booking->date_fin->format('d/m/Y') : 'N/A' }}
                                        </small>
                                    </td>
                                    <td>{{ number_format($booking->montant_total ?? 0, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        @if($booking->statut == 'CONFIRME')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Confirmée
                                            </span>
                                        @elseif($booking->statut == 'EN_ATTENTE')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock mr-1"></i>
                                                En attente
                                            </span>
                                        @elseif($booking->statut == 'ANNULE')
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Annulée
                                            </span>
                                        @else
                                            <span class="badge badge-info">
                                                <i class="fas fa-flag-checkered mr-1"></i>
                                                Terminée
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                               class="btn btn-sm btn-primary mb-2">
                                                <i class="fas fa-eye mr-1"></i>
                                                {{ __('messages.admin.view') }}
                                            </a>
                                            <select wire:change="updateStatus({{ $booking->id }}, $event.target.value)" 
                                                    class="form-control form-control-sm">
                                                <option value="EN_ATTENTE" {{ $booking->statut == 'EN_ATTENTE' ? 'selected' : '' }}>En attente</option>
                                                <option value="CONFIRME" {{ $booking->statut == 'CONFIRME' ? 'selected' : '' }}>Confirmée</option>
                                                <option value="ANNULE" {{ $booking->statut == 'ANNULE' ? 'selected' : '' }}>Annulée</option>
                                                <option value="TERMINE" {{ $booking->statut == 'TERMINE' ? 'selected' : '' }}>Terminée</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p class="mb-0">Aucune réservation trouvée</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($bookings->hasPages())
                <div class="card-footer">
                    {{ $bookings->links() }}
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
