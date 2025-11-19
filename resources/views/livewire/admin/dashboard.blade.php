<div>
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row">
        <!-- Total Properties -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-primary hover-lift">
                <div class="inner">
                    <h3>{{ number_format($stats['properties']) }}</h3>
                    <p>{{ __('messages.admin.total_properties') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-home"></i>
                </div>
                <a href="{{ route('admin.properties') }}" class="small-box-footer">
                    Plus d'infos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Bookings -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-success hover-lift">
                <div class="inner">
                    <h3>{{ number_format($stats['bookings']) }}</h3>
                    <p>{{ __('messages.admin.total_bookings') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <a href="{{ route('admin.bookings') }}" class="small-box-footer">
                    Plus d'infos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-warning hover-lift">
                <div class="inner">
                    <h3>{{ number_format($stats['total_revenue'] ?? 0, 0, ',', ' ') }} FCFA</h3>
                    <p>{{ __('messages.admin.total_revenue') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <a href="{{ route('admin.payments') }}" class="small-box-footer">
                    Plus d'infos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-danger hover-lift">
                <div class="inner">
                    <h3>{{ number_format($stats['total_users']) }}</h3>
                    <p>Utilisateurs actifs</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Plus d'infos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Monthly Revenue Chart -->
        <div class="col-lg-8">
            <div class="card shadow-lg animate-on-scroll">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-2"></i>
                        Revenus mensuels
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Bookings Chart -->
        <div class="col-lg-4">
            <div class="card shadow-lg animate-on-scroll">
                <div class="card-header bg-gradient-success text-white">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-2"></i>
                        Réservations par statut
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="bookingsChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <!-- Recent Bookings -->
        <div class="col-lg-6">
            <div class="card shadow animate-on-scroll">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Réservations récentes
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Propriété</th>
                                    <th>Client</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings ?? [] as $booking)
                                <tr>
                                    <td>{{ $booking->property->title ?? 'N/A' }}</td>
                                    <td>{{ $booking->user->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($booking->status == 'confirmed')
                                            <span class="badge badge-success">Confirmée</span>
                                        @elseif($booking->status == 'pending')
                                            <span class="badge badge-warning">En attente</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $booking->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $booking->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Aucune réservation récente</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($recentBookings ?? []) > 0)
                <div class="card-footer text-center">
                    <a href="{{ route('admin.bookings') }}" class="btn btn-sm btn-primary">
                        Voir toutes les réservations
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Recent Properties -->
        <div class="col-lg-6">
            <div class="card shadow animate-on-scroll">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-building mr-2"></i>
                        Propriétés récentes
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Titre</th>
                                    <th>Type</th>
                                    <th>Prix</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentProperties ?? [] as $property)
                                <tr>
                                    <td>{{ $property->title }}</td>
                                    <td>{{ ucfirst($property->type) }}</td>
                                    <td>{{ number_format($property->price, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        @if($property->availability_status == 'available')
                                            <span class="badge badge-success">Disponible</span>
                                        @else
                                            <span class="badge badge-danger">Occupée</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Aucune propriété récente</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($recentProperties ?? []) > 0)
                <div class="card-footer text-center">
                    <a href="{{ route('admin.properties') }}" class="btn btn-sm btn-primary">
                        Voir toutes les propriétés
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Additional Info Cards -->
    <div class="row">
        <div class="col-md-3 col-6">
            <div class="info-box bg-gradient-info hover-lift">
                <span class="info-box-icon"><i class="fas fa-sync-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">RENOUVELLEMENTS</span>
                    <span class="info-box-number">{{ $stats['active_bookings'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="info-box bg-gradient-warning hover-lift">
                <span class="info-box-icon"><i class="fas fa-tools"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">MAINTENANCE</span>
                    <span class="info-box-number">{{ $stats['urgent_maintenance'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="info-box bg-gradient-success hover-lift">
                <span class="info-box-icon"><i class="fas fa-user-tie"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">PROMOTEURS</span>
                    <span class="info-box-number">{{ $stats['promoters'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-6">
            <div class="info-box bg-gradient-danger hover-lift">
                <span class="info-box-icon"><i class="fas fa-envelope"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">CONTACTS</span>
                    <span class="info-box-number">{{ $stats['pending_contacts'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Revenue Chart
    var revenueCtx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyData['labels'] ?? []) !!},
            datasets: [{
                label: 'Revenus (FCFA)',
                data: {!! json_encode(array_column($monthlyRevenue ?? [], 'amount')) !!},
                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                borderColor: 'rgba(52, 152, 219, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('fr-FR') + ' FCFA';
                        }
                    }
                }
            }
        }
    });

    // Bookings Chart
    var bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
    var bookingsChart = new Chart(bookingsCtx, {
        type: 'doughnut',
        data: {
            labels: ['Confirmées', 'En attente', 'Annulées'],
            datasets: [{
                data: {!! json_encode([
                    $bookingStats['confirmed'] ?? 0,
                    $bookingStats['pending'] ?? 0,
                    $bookingStats['cancelled'] ?? 0
                ]) !!},
                backgroundColor: [
                    'rgba(39, 174, 96, 0.8)',
                    'rgba(243, 156, 18, 0.8)',
                    'rgba(231, 76, 60, 0.8)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endpush
