<div>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Envoyer une notification
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.notifications.index') }}">Notifications</a></li>
                            <li class="breadcrumb-item active">Créer</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
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
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit mr-2"></i>
                        Formulaire de notification
                    </h5>
                </div>
                <div class="card-body">
                    <form wire:submit="envoyer">
                        <div class="form-group">
                            <label for="utilisateur_id">Destinataire <span class="text-danger">*</span></label>
                            <select wire:model="utilisateur_id" class="form-control @error('utilisateur_id') is-invalid @enderror" id="utilisateur_id">
                                <option value="">Sélectionner un utilisateur</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->nom ?? '' }} {{ $user->prenom ?? '' }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('utilisateur_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Type <span class="text-danger">*</span></label>
                                    <select wire:model="type" class="form-control @error('type') is-invalid @enderror" id="type">
                                        <option value="INFO">Information</option>
                                        <option value="VALIDATION">Validation</option>
                                        <option value="RESERVATION">Réservation</option>
                                        <option value="PAIEMENT">Paiement</option>
                                        <option value="REJET">Rejet</option>
                                    </select>
                                    @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="canal">Canal <span class="text-danger">*</span></label>
                                    <select wire:model="canal" class="form-control @error('canal') is-invalid @enderror" id="canal">
                                        <option value="EMAIL">Email</option>
                                        <option value="SMS">SMS</option>
                                        <option value="IN_APP">Dans l'application</option>
                                    </select>
                                    @error('canal') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="priorite">Priorité <span class="text-danger">*</span></label>
                            <select wire:model="priorite" class="form-control @error('priorite') is-invalid @enderror" id="priorite">
                                <option value="NORMALE">Normale</option>
                                <option value="HAUTE">Haute</option>
                                <option value="URGENTE">Urgente</option>
                            </select>
                            @error('priorite') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="contenu">Contenu <span class="text-danger">*</span></label>
                            <textarea wire:model="contenu" 
                                      class="form-control @error('contenu') is-invalid @enderror" 
                                      id="contenu" 
                                      rows="6" 
                                      placeholder="Saisissez le contenu de la notification..."></textarea>
                            @error('contenu') <span class="text-danger">{{ $message }}</span> @enderror
                            <small class="form-text text-muted">
                                {{ strlen($contenu) }}/500 caractères
                            </small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane mr-1"></i>
                                Envoyer la notification
                            </button>
                            <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Aperçu -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-eye mr-2"></i>
                        Aperçu
                    </h5>
                </div>
                <div class="card-body">
                    @if($utilisateur_id)
                        @php
                            $user = \App\Models\User::find($utilisateur_id);
                        @endphp
                        <p><strong>Destinataire:</strong><br>
                        {{ $user->nom ?? '' }} {{ $user->prenom ?? '' }}<br>
                        <small class="text-muted">{{ $user->email ?? '' }}</small></p>
                    @else
                        <p class="text-muted">Sélectionnez un destinataire</p>
                    @endif
                    <hr>
                    <p><strong>Type:</strong> {{ $type }}</p>
                    <p><strong>Canal:</strong> {{ $canal }}</p>
                    <p><strong>Priorité:</strong> 
                        @if($priorite == 'URGENTE')
                            <span class="badge badge-danger">{{ $priorite }}</span>
                        @elseif($priorite == 'HAUTE')
                            <span class="badge badge-warning">{{ $priorite }}</span>
                        @else
                            <span class="badge badge-secondary">{{ $priorite }}</span>
                        @endif
                    </p>
                    <hr>
                    <p><strong>Contenu:</strong></p>
                    <div class="border p-3 bg-light rounded">
                        {{ $contenu ?: 'Aperçu du contenu...' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

