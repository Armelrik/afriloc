@extends('layouts.admin')

@section('title', 'Exemples UI - Éléments d\'interface')

@section('content')
<div class="container-fluid">
    <!-- En-tête de page -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg animate-on-scroll">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-palette mr-2"></i>
                        Exemples d'éléments UI
                    </h3>
                </div>
                <div class="card-body">
                    <p class="mb-0">
                        Cette page démontre l'utilisation des styles personnalisés et des fonctions JavaScript utilitaires.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Boxes -->
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-3">
                <i class="fas fa-square-full text-primary mr-2"></i>
                Info Boxes
            </h4>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-gradient-primary hover-lift">
                <span class="info-box-icon">
                    <i class="fas fa-users"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">UTILISATEURS</span>
                    <span class="info-box-number">1,234</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-gradient-success hover-lift">
                <span class="info-box-icon">
                    <i class="fas fa-chart-line"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">REVENUS</span>
                    <span class="info-box-number" id="revenue-display">50 000 FCFA</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-gradient-warning hover-lift">
                <span class="info-box-icon">
                    <i class="fas fa-shopping-cart"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">COMMANDES</span>
                    <span class="info-box-number">567</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-gradient-danger hover-lift">
                <span class="info-box-icon">
                    <i class="fas fa-star"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">ÉVALUATIONS</span>
                    <span class="info-box-number">4.8</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Boutons -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow animate-on-scroll">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-mouse-pointer mr-2"></i>
                        Boutons & Actions
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Boutons standards</h5>
                            <button class="btn btn-primary mb-2">
                                <i class="fas fa-save mr-2"></i>Enregistrer
                            </button>
                            <button class="btn btn-success mb-2">
                                <i class="fas fa-check mr-2"></i>Valider
                            </button>
                            <button class="btn btn-warning mb-2">
                                <i class="fas fa-exclamation-triangle mr-2"></i>Attention
                            </button>
                            <button class="btn btn-danger mb-2">
                                <i class="fas fa-trash mr-2"></i>Supprimer
                            </button>
                            <button class="btn btn-info mb-2">
                                <i class="fas fa-info-circle mr-2"></i>Information
                            </button>
                        </div>
                        <div class="col-md-6">
                            <h5>Actions JavaScript</h5>
                            <button class="btn btn-primary mb-2" onclick="showSuccess('Opération réussie !')">
                                <i class="fas fa-check-circle mr-2"></i>Message succès
                            </button>
                            <button class="btn btn-danger mb-2" onclick="showError('Une erreur est survenue')">
                                <i class="fas fa-times-circle mr-2"></i>Message erreur
                            </button>
                            <button class="btn btn-warning mb-2" onclick="confirmAction('Confirmer ?', 'Êtes-vous sûr ?', () => showSuccess('Confirmé !'))">
                                <i class="fas fa-question-circle mr-2"></i>Confirmation
                            </button>
                            <button class="btn btn-info mb-2" onclick="copyToClipboard('Texte copié !', this)">
                                <i class="fas fa-copy mr-2"></i>Copier
                            </button>
                            <button class="btn btn-secondary mb-2" onclick="showLoader(); setTimeout(hideLoader, 2000)">
                                <i class="fas fa-spinner mr-2"></i>Loader
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Badges & Alerts -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow animate-on-scroll">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-tag mr-2"></i>
                        Badges
                    </h4>
                </div>
                <div class="card-body">
                    <span class="badge badge-primary">Primary</span>
                    <span class="badge badge-success">Success</span>
                    <span class="badge badge-danger">Danger</span>
                    <span class="badge badge-warning">Warning</span>
                    <span class="badge badge-info">Info</span>
                    <span class="badge badge-dark">Dark</span>
                    <span class="badge badge-light">Light</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow animate-on-scroll">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-bell mr-2"></i>
                        Alertes
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>
                        Opération réussie !
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        Une erreur est survenue
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaires -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow animate-on-scroll">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-edit mr-2"></i>
                        Formulaires
                    </h4>
                </div>
                <div class="card-body">
                    <form id="demo-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nom">Nom complet</label>
                                    <input type="text" class="form-control" id="nom" placeholder="Entrez votre nom">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="votre@email.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="select-basic">Sélection simple</label>
                                    <select class="form-control" id="select-basic">
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                        <option>Option 3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="select2-demo">Select2 amélioré</label>
                                    <select class="form-control select2-demo" id="select2-demo">
                                        <option></option>
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                        <option>Option 3</option>
                                        <option>Option 4</option>
                                        <option>Option 5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea class="form-control" id="message" rows="3" placeholder="Votre message..."></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane mr-2"></i>Envoyer
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-redo mr-2"></i>Réinitialiser
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau avec DataTables -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow animate-on-scroll">
                <div class="card-header bg-gradient-dark text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-table mr-2"></i>
                        Tableau avec DataTables
                    </h4>
                </div>
                <div class="card-body">
                    <table id="demo-table" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 1; $i <= 20; $i++)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>Utilisateur {{ $i }}</td>
                                <td>user{{ $i }}@example.com</td>
                                <td>
                                    @if($i % 3 == 0)
                                        <span class="badge badge-success">Actif</span>
                                    @elseif($i % 3 == 1)
                                        <span class="badge badge-warning">En attente</span>
                                    @else
                                        <span class="badge badge-danger">Inactif</span>
                                    @endif
                                </td>
                                <td>{{ now()->subDays($i)->format('d/m/Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-toggle="tooltip" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Classes utilitaires -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow animate-on-scroll">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-magic mr-2"></i>
                        Classes utilitaires
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card shadow-sm hover-lift">
                                <div class="card-body text-center">
                                    <i class="fas fa-arrow-up fa-3x text-primary mb-3"></i>
                                    <h5>Hover Lift</h5>
                                    <p class="text-muted">Survole pour voir l'effet</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card shadow hover-scale">
                                <div class="card-body text-center">
                                    <i class="fas fa-expand fa-3x text-success mb-3"></i>
                                    <h5>Hover Scale</h5>
                                    <p class="text-muted">Survole pour voir l'effet</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card shadow-lg rounded-xl">
                                <div class="card-body text-center">
                                    <i class="fas fa-star fa-3x text-warning mb-3"></i>
                                    <h5>Rounded XL</h5>
                                    <p class="text-muted">Coins très arrondis</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-gradient-primary mb-3">Texte avec gradient</h5>
                            <div class="bg-gradient-primary text-white p-3 rounded-lg mb-2">
                                Background gradient primary
                            </div>
                            <div class="bg-gradient-success text-white p-3 rounded-lg mb-2">
                                Background gradient success
                            </div>
                            <div class="bg-gradient-danger text-white p-3 rounded-lg">
                                Background gradient danger
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fonctions JavaScript -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow animate-on-scroll">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-code mr-2"></i>
                        Fonctions JavaScript disponibles
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-gradient-dark text-white">
                                <tr>
                                    <th>Fonction</th>
                                    <th>Description</th>
                                    <th>Exemple</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>formatNumber()</code></td>
                                    <td>Formate un nombre</td>
                                    <td><span id="format-number-demo"></span></td>
                                </tr>
                                <tr>
                                    <td><code>formatCurrency()</code></td>
                                    <td>Formate une devise</td>
                                    <td><span id="format-currency-demo"></span></td>
                                </tr>
                                <tr>
                                    <td><code>formatDate()</code></td>
                                    <td>Formate une date</td>
                                    <td><span id="format-date-demo"></span></td>
                                </tr>
                                <tr>
                                    <td><code>calculatePercentageChange()</code></td>
                                    <td>Calcule un pourcentage</td>
                                    <td><span id="percentage-demo"></span></td>
                                </tr>
                                <tr>
                                    <td><code>scrollToTop()</code></td>
                                    <td>Retour en haut</td>
                                    <td><button class="btn btn-sm btn-primary" onclick="scrollToTop()">Tester</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialiser Select2
    initSelect2('.select2-demo', {
        placeholder: 'Sélectionner une option'
    });

    // Initialiser DataTables
    initDataTable('#demo-table', {
        order: [[0, 'desc']],
        pageLength: 10
    });

    // Initialiser les tooltips
    initTooltips();

    // Démo des fonctions de formatage
    document.getElementById('format-number-demo').textContent = formatNumber(1234567);
    document.getElementById('format-currency-demo').textContent = formatCurrency(50000);
    document.getElementById('format-date-demo').textContent = formatDate(new Date());
    document.getElementById('percentage-demo').textContent = calculatePercentageChange(100, 150);
    document.getElementById('revenue-display').textContent = formatCurrency(50000);

    // Gestion du formulaire
    document.getElementById('demo-form').addEventListener('submit', function(e) {
        e.preventDefault();
        showLoader();
        
        // Simuler un délai
        setTimeout(function() {
            hideLoader();
            showSuccess('Formulaire soumis avec succès !');
        }, 1500);
    });

    // Animer les cartes au scroll (déjà fait automatiquement)
    console.log('Page UI Elements chargée et initialisée');
});
</script>
@endpush

@push('styles')
<style>
/* Styles supplémentaires pour cette page de démo */
.demo-box {
    padding: 2rem;
    border: 2px dashed #ddd;
    border-radius: 8px;
    text-align: center;
    margin-bottom: 1rem;
}

.demo-box:hover {
    border-color: var(--primary-color);
    background-color: rgba(52, 152, 219, 0.05);
}

code {
    background-color: #f4f6f9;
    padding: 2px 6px;
    border-radius: 4px;
    color: #e74c3c;
    font-weight: 600;
}
</style>
@endpush

