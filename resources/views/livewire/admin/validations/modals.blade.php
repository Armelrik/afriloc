<!-- Approve Modal -->
@if($showApproveModal && $validation)
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
                    <li><strong>Promoteur:</strong> {{ $validation->promoteur->user->nom ?? '' }} {{ $validation->promoteur->user->prenom ?? '' }}</li>
                    <li><strong>Raison sociale:</strong> {{ $validation->promoteur->raison_sociale ?? 'N/A' }}</li>
                    <li><strong>Score complétude:</strong> {{ $validation->score_completude ?? 0 }}%</li>
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
@if($showRejectModal && $validation)
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
                <p>Promoteur: <strong>{{ $validation->promoteur->user->nom ?? '' }} {{ $validation->promoteur->user->prenom ?? '' }}</strong></p>
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
@if($showIncompleteModal && $validation)
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
                <p>Promoteur: <strong>{{ $validation->promoteur->user->nom ?? '' }} {{ $validation->promoteur->user->prenom ?? '' }}</strong></p>
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

