<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">
                    <i class="fas fa-building mr-2"></i>
                    {{ __('messages.admin.properties') }}
                </h1>
                <a href="/admin/properties/create" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('messages.admin.add_property') }}
                </a>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" wire:model.live="search" class="form-control" placeholder="Rechercher...">
        </div>
        <div class="col-md-2">
            <select wire:model.live="typeFilter" class="form-control">
                <option value="">Tous les types</option>
                <option value="appartement">Appartement</option>
                <option value="maison">Maison</option>
                <option value="terrain">Terrain</option>
                <option value="bureau">Bureau</option>
                <option value="local_commercial">Local commercial</option>
            </select>
        </div>
        <div class="col-md-2">
            <select wire:model.live="statusFilter" class="form-control">
                <option value="">Tous les statuts</option>
                <option value="disponible">Disponible</option>
                <option value="loue">Loué</option>
                <option value="reserve">Réservé</option>
                <option value="indisponible">Indisponible</option>
            </select>
        </div>
        <div class="col-md-2">
            <button wire:click="resetFilters" class="btn btn-secondary btn-block">
                <i class="fas fa-redo mr-2"></i>
                Réinitialiser
            </button>
        </div>
    </div>

    <!-- Properties Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg animate-on-scroll">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Liste des propriétés
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="properties-table" class="table table-bordered table-striped table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>{{ __('messages.admin.title') }}</th>
                                    <th>{{ __('messages.admin.type') }}</th>
                                    <th>{{ __('messages.admin.price') }}</th>
                                    <th>Promoteur</th>
                                    <th>{{ __('messages.admin.status') }}</th>
                                    <th>{{ __('messages.admin.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($properties as $property)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($property->medias && $property->medias->where('type_media', 'IMAGE')->first())
                                                <img src="{{ $property->medias->where('type_media', 'IMAGE')->first()->public_url }}" 
                                                     alt="{{ $property->titre }}" 
                                                     class="img-thumbnail mr-2" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @endif
                                            <span>{{ $property->titre }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ ucfirst($property->type_bien) }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($property->prix_location ?? 0, 0, ',', ' ') }} FCFA</td>
                                    <td>{{ $property->promoteur->user->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($property->disponibilite == 'disponible')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Disponible
                                            </span>
                                        @elseif($property->disponibilite == 'loue')
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Loué
                                            </span>
                                        @elseif($property->disponibilite == 'reserve')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock mr-1"></i>
                                                Réservé
                                            </span>
                                        @elseif($property->disponibilite == 'indisponible')
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-ban mr-1"></i>
                                                Indisponible
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-ban mr-1"></i>
                                                {{ ucfirst($property->disponibilite ?? 'N/A') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.properties.show', $property->id) }}" 
                                               class="btn btn-sm btn-info" 
                                               data-toggle="tooltip" 
                                               title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.properties.edit', $property->id) }}" 
                                               class="btn btn-sm btn-warning" 
                                               data-toggle="tooltip" 
                                               title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button wire:click="delete({{ $property->id }})" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette propriété ?')"
                                                    data-toggle="tooltip" 
                                                    title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p class="mb-0">Aucune propriété trouvée</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($properties->hasPages())
                <div class="card-footer">
                    {{ $properties->links() }}
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
    // Initialiser les tooltips
    initTooltips();
});
</script>
@endpush
