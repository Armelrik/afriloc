<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <i class="fas fa-clipboard-check mr-2"></i>
                Gestion des demandes de validation
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

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-md-3">
            <select wire:model.live="filterStatus" class="form-control">
                <option value="">Toutes les demandes</option>
                <option value="EN_ATTENTE">En attente</option>
                <option value="VALIDE">Validées</option>
                <option value="REJETE">Rejetées</option>
                <option value="INCOMPLET">Incomplètes</option>
            </select>
        </div>
        <div class="col-md-6">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Rechercher par nom, email ou raison sociale...">
        </div>
        <div class="col-md-3 text-right">
            <a href="{{ route('admin.validations.history') }}" class="btn btn-info">
                <i class="fas fa-history mr-1"></i>
                Historique
            </a>
        </div>
    </div>

    <!-- Validations Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Liste des demandes de validation
                        @if($pendingCount > 0)
                            <span class="badge badge-warning ml-2">{{ $pendingCount }} en attente</span>
                        @endif
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Promoteur</th>
                                    <th>Raison sociale</th>
                                    <th>Score complétude</th>
                                    <th>Statut</th>
                                    <th>Date demande</th>
                                    <th>Traitée par</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($validations as $validation)
                                <tr>
                                    <td>
                                        <strong>{{ $validation->promoteur->user->nom ?? '' }} {{ $validation->promoteur->user->prenom ?? '' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $validation->promoteur->user->email ?? 'N/A' }}</small>
                                    </td>
                                    <td>{{ $validation->promoteur->raison_sociale ?? 'N/A' }}</td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar {{ $validation->score_completude >= 100 ? 'bg-success' : ($validation->score_completude >= 70 ? 'bg-warning' : 'bg-danger') }}" 
                                                 role="progressbar" 
                                                 style="width: {{ $validation->score_completude ?? 0 }}%"
                                                 aria-valuenow="{{ $validation->score_completude ?? 0 }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                {{ $validation->score_completude ?? 0 }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($validation->statut == 'VALIDE')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Validée
                                            </span>
                                        @elseif ($validation->statut == 'EN_ATTENTE')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock mr-1"></i>
                                                En attente
                                            </span>
                                        @elseif ($validation->statut == 'INCOMPLET')
                                            <span class="badge badge-info">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                Incomplète
                                            </span>
                                        @elseif ($validation->statut == 'REJETE')
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Rejetée
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $validation->date_demande ? $validation->date_demande->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        @if($validation->traitePar)
                                            {{ $validation->traitePar->nom ?? '' }} {{ $validation->traitePar->prenom ?? '' }}
                                            @if($validation->date_traitement)
                                                <br><small class="text-muted">{{ $validation->date_traitement->format('d/m/Y H:i') }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.validations.show', $validation->id) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($validation->statut == 'EN_ATTENTE')
                                                <button wire:click="openApproveModal({{ $validation->id }})" 
                                                        class="btn btn-sm btn-success" 
                                                        title="Approuver">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button wire:click="openRejectModal({{ $validation->id }})" 
                                                        class="btn btn-sm btn-danger" 
                                                        title="Rejeter">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <button wire:click="openIncompleteModal({{ $validation->id }})" 
                                                        class="btn btn-sm btn-warning" 
                                                        title="Demander complément">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Aucune demande de validation trouvée</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $validations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
@if($showApproveModal && $selectedValidation)
<div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle mr-2"></i>
                    Approuver la demande de validation
                </h5>
                <button type="button" class="close text-white" wire:click="closeModals">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir approuver la demande de validation pour :</p>
                <ul>
                    <li><strong>Promoteur:</strong> {{ $selectedValidation->promoteur->user->nom ?? '' }} {{ $selectedValidation->promoteur->user->prenom ?? '' }}</li>
                    <li><strong>Raison sociale:</strong> {{ $selectedValidation->promoteur->raison_sociale ?? 'N/A' }}</li>
                    <li><strong>Score complétude:</strong> {{ $selectedValidation->score_completude ?? 0 }}%</li>
                </ul>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i>
                    Le promoteur recevra une notification de validation et pourra commencer à publier des biens.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Annuler</button>
                <button type="button" class="btn btn-success" wire:click="approve">
                    <i class="fas fa-check mr-1"></i>
                    Confirmer l'approbation
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif

<!-- Reject Modal -->
@if($showRejectModal && $selectedValidation)
<div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-times-circle mr-2"></i>
                    Rejeter la demande de validation
                </h5>
                <button type="button" class="close text-white" wire:click="closeModals">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Promoteur: <strong>{{ $selectedValidation->promoteur->user->nom ?? '' }} {{ $selectedValidation->promoteur->user->prenom ?? '' }}</strong></p>
                <div class="form-group">
                    <label for="rejectMotif">Motif du rejet <span class="text-danger">*</span></label>
                    <textarea wire:model="rejectMotif" 
                              class="form-control" 
                              id="rejectMotif" 
                              rows="4" 
                              placeholder="Expliquez le motif du rejet..."></textarea>
                    @error('rejectMotif') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Annuler</button>
                <button type="button" class="btn btn-danger" wire:click="reject">
                    <i class="fas fa-times mr-1"></i>
                    Confirmer le rejet
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif

<!-- Incomplete Modal -->
@if($showIncompleteModal && $selectedValidation)
<div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Demander des documents complémentaires
                </h5>
                <button type="button" class="close text-white" wire:click="closeModals">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Promoteur: <strong>{{ $selectedValidation->promoteur->user->nom ?? '' }} {{ $selectedValidation->promoteur->user->prenom ?? '' }}</strong></p>
                <div class="form-group">
                    <label for="incompleteCommentaires">Commentaires / Documents manquants <span class="text-danger">*</span></label>
                    <textarea wire:model="incompleteCommentaires" 
                              class="form-control" 
                              id="incompleteCommentaires" 
                              rows="4" 
                              placeholder="Listez les documents manquants ou les éléments à corriger..."></textarea>
                    @error('incompleteCommentaires') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="closeModals">Annuler</button>
                <button type="button" class="btn btn-warning" wire:click="requestIncomplete">
                    <i class="fas fa-paper-plane mr-1"></i>
                    Envoyer la demande
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif
</div>

