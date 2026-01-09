<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <i class="fas fa-cogs mr-2"></i>
                Paramètres du système
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

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header p-0">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab === 'general' ? 'active' : '' }}" 
                               wire:click="switchTab('general')" 
                               href="#">
                                <i class="fas fa-cog mr-1"></i>
                                Général
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab === 'validation' ? 'active' : '' }}" 
                               wire:click="switchTab('validation')" 
                               href="#">
                                <i class="fas fa-clipboard-check mr-1"></i>
                                Validation
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab === 'commissions' ? 'active' : '' }}" 
                               wire:click="switchTab('commissions')" 
                               href="#">
                                <i class="fas fa-money-bill-wave mr-1"></i>
                                Commissions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab === 'notifications' ? 'active' : '' }}" 
                               wire:click="switchTab('notifications')" 
                               href="#">
                                <i class="fas fa-bell mr-1"></i>
                                Notifications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab === 'documents' ? 'active' : '' }}" 
                               wire:click="switchTab('documents')" 
                               href="#">
                                <i class="fas fa-file-alt mr-1"></i>
                                Documents
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <!-- Onglet Général -->
                    @if($activeTab === 'general')
                    <form wire:submit="saveGeneral">
                        <div class="form-group">
                            <label for="nomPlateforme">Nom de la plateforme</label>
                            <input type="text" wire:model="nomPlateforme" class="form-control" id="nomPlateforme">
                        </div>
                        <div class="form-group">
                            <label for="emailContact">Email de contact</label>
                            <input type="email" wire:model="emailContact" class="form-control" id="emailContact">
                        </div>
                        <div class="form-group">
                            <label for="telephoneContact">Téléphone de contact</label>
                            <input type="text" wire:model="telephoneContact" class="form-control" id="telephoneContact">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>
                            Enregistrer
                        </button>
                    </form>
                    @endif

                    <!-- Onglet Validation -->
                    @if($activeTab === 'validation')
                    <form wire:submit="saveValidation">
                        <div class="form-group">
                            <label for="pourcentageMinDocuments">Pourcentage minimum de documents requis (%)</label>
                            <input type="number" wire:model="pourcentageMinDocuments" class="form-control" id="pourcentageMinDocuments" min="0" max="100">
                            <small class="form-text text-muted">Le promoteur doit avoir au moins ce pourcentage de documents pour soumettre sa demande.</small>
                        </div>
                        <div class="form-group">
                            <label for="delaiValidation">Délai de validation (jours)</label>
                            <input type="number" wire:model="delaiValidation" class="form-control" id="delaiValidation" min="1">
                            <small class="form-text text-muted">Délai maximum pour traiter une demande de validation.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>
                            Enregistrer
                        </button>
                    </form>
                    @endif

                    <!-- Onglet Commissions -->
                    @if($activeTab === 'commissions')
                    <form wire:submit="saveCommissions">
                        <div class="form-group">
                            <label for="pourcentagePlateforme">Pourcentage de commission plateforme (%)</label>
                            <input type="number" wire:model="pourcentagePlateforme" class="form-control" id="pourcentagePlateforme" step="0.1" min="0" max="100">
                            <small class="form-text text-muted">Pourcentage prélevé par la plateforme sur chaque paiement.</small>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Le montant restant ({{ 100 - $pourcentagePlateforme }}%) sera reversé au promoteur.
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>
                            Enregistrer
                        </button>
                    </form>
                    @endif

                    <!-- Onglet Notifications -->
                    @if($activeTab === 'notifications')
                    <form wire:submit="saveNotifications">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" wire:model="activerEmail" class="custom-control-input" id="activerEmail">
                                <label class="custom-control-label" for="activerEmail">Activer les notifications par email</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" wire:model="activerSMS" class="custom-control-input" id="activerSMS">
                                <label class="custom-control-label" for="activerSMS">Activer les notifications par SMS</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>
                            Enregistrer
                        </button>
                    </form>
                    @endif

                    <!-- Onglet Documents -->
                    @if($activeTab === 'documents')
                    <form wire:submit="saveDocuments">
                        <div class="form-group">
                            <label for="formatsAcceptes">Formats de fichiers acceptés</label>
                            <input type="text" wire:model="formatsAcceptes" class="form-control" id="formatsAcceptes" placeholder="PDF,JPG,PNG">
                            <small class="form-text text-muted">Séparez les formats par des virgules.</small>
                        </div>
                        <div class="form-group">
                            <label for="tailleMax">Taille maximale par fichier (MB)</label>
                            <input type="number" wire:model="tailleMax" class="form-control" id="tailleMax" min="1" max="50">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>
                            Enregistrer
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>

