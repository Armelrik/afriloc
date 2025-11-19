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
                <option value="pending">En attente</option>
                <option value="confirmed">Confirmée</option>
                <option value="cancelled">Annulée</option>
                <option value="completed">Terminée</option>
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
                                            <strong>{{ $booking->user->name ?? $booking->customer_name }}</strong>
                                        </div>
                                        <small class="text-muted">{{ $booking->user->email ?? $booking->customer_email }}</small>
                                    </td>
                                    <td>
                                        @if($booking->property)
                                            <a href="{{ route('properties.show', $booking->property->id) }}" target="_blank">
                                                {{ $booking->property->title }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        <small>
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $booking->start_date->format('d/m/Y') }} <br>
                                            <i class="fas fa-arrow-right mr-1"></i>
                                            {{ $booking->end_date->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td>{{ number_format($booking->total_price, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        @if($booking->status == 'confirmed')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Confirmée
                                            </span>
                                        @elseif($booking->status == 'pending')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock mr-1"></i>
                                                En attente
                                            </span>
                                        @elseif($booking->status == 'cancelled')
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
                                        <select wire:change="updateStatus({{ $booking->id }}, $event.target.value)" 
                                                class="form-control form-control-sm">
                                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Terminée</option>
                                        </select>
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
