<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <i class="fas fa-envelope mr-2"></i>
                Messages de contact
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
                <option value="">Tous les messages</option>
                <option value="unread">Non lus</option>
                <option value="read">Lus</option>
                <option value="responded">Répondus</option>
            </select>
        </div>
    </div>

    <!-- Contacts Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg animate-on-scroll">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Liste des messages
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="contacts-table" class="table table-bordered table-striped table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Sujet</th>
                                    <th>Message</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($contacts as $contact)
                                <tr class="{{ $contact->status == 'unread' ? 'table-warning' : '' }}">
                                    <td><strong>{{ $contact->name }}</strong></td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->subject }}</td>
                                    <td>
                                        <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            {{ $contact->message }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($contact->status == 'unread')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-envelope mr-1"></i>
                                                Non lu
                                            </span>
                                        @elseif ($contact->status == 'read')
                                            <span class="badge badge-info">
                                                <i class="fas fa-envelope-open mr-1"></i>
                                                Lu
                                            </span>
                                        @else
                                            <span class="badge badge-success">
                                                <i class="fas fa-reply mr-1"></i>
                                                Répondu
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button wire:click="markAsRead({{ $contact->id }})" 
                                                    class="btn btn-sm btn-info" 
                                                    data-toggle="tooltip" 
                                                    title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button wire:click="respond({{ $contact->id }})" 
                                                    class="btn btn-sm btn-success" 
                                                    data-toggle="tooltip" 
                                                    title="Répondre">
                                                <i class="fas fa-reply"></i>
                                            </button>
                                            <button wire:click="delete({{ $contact->id }})" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Supprimer ce message ?')"
                                                    data-toggle="tooltip" 
                                                    title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p class="mb-0">Aucun message trouvé</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($contacts->hasPages())
                <div class="card-footer">
                    {{ $contacts->links() }}
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
