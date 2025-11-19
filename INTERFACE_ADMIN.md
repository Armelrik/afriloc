# 🏢 AfriLoc - Interface Administrateur

## 📋 Vue d'ensemble

L'interface administrateur AfriLoc utilise **AdminLTE 3** avec des **styles personnalisés** pour offrir une expérience de gestion moderne et professionnelle.

## 🎨 Technologies utilisées

### Framework & Templates
- **Laravel 12** - Framework PHP
- **AdminLTE 3** - Template d'administration
- **Bootstrap 4** - Framework CSS
- **jQuery** - Bibliothèque JavaScript

### Plugins & Bibliothèques
- **DataTables** - Tableaux avancés avec tri, recherche et pagination
- **Select2** - Sélecteurs améliorés avec recherche
- **Chart.js** - Graphiques et visualisations
- **SweetAlert2** - Alertes et confirmations modernes
- **Font Awesome 5** - Icônes
- **Leaflet** - Cartes interactives
- **Summernote** - Éditeur WYSIWYG

## 🏗️ Structure de l'interface

### Layout principal
```
resources/views/layouts/admin.blade.php
├── components/header.blade.php    (Navbar avec notifications)
├── components/menu.blade.php      (Sidebar avec navigation)
├── @yield('content')              (Contenu de la page)
└── components/footer.blade.php    (Footer)
```

### Composants

#### 1. Header (Navbar)
- Logo de l'application
- Barre de recherche
- Notifications en temps réel
- Messages
- Menu utilisateur
- Mode plein écran

#### 2. Sidebar (Menu)
- Logo et nom de l'application
- Informations utilisateur
- Navigation principale :
  - 📊 Tableau de bord
  - 📈 Analytics
  - 🏠 Palette (propriétés)
  - 🏪 Points de vente (Boutiques, Entrepôts, Usines)
  - 🏷️ Catégories
  - 💰 Promotions
  - 📢 Publicités
  - 👥 Administration (Utilisateurs, Rôles)
  - 📊 Activité (Transactions, Scans)
  - 📄 Rapports
  - ⚙️ Paramètres

#### 3. Content Area
Zone principale pour afficher le contenu dynamique des pages.

#### 4. Footer
Informations de copyright et version.

## 🎨 Styles personnalisés

Le fichier `public/assets/css/style.css` contient :

### Variables CSS
```css
--primary-color: #3498db
--secondary-color: #2c3e50
--accent-color: #e74c3c
--success-color: #27ae60
--warning-color: #f39c12
--danger-color: #e74c3c
```

### Fonctionnalités CSS
- ✅ Navbar avec effets de survol fluides
- ✅ Sidebar avec dégradé et animations
- ✅ Cards modernes avec hover effects
- ✅ Boutons avec gradients
- ✅ Alerts stylisées avec animations
- ✅ Tables avec DataTables intégré
- ✅ Formulaires optimisés
- ✅ Badges et notifications animés
- ✅ Responsive design complet
- ✅ Animations CSS (fade-in, slide-in, etc.)

### Classes utilitaires disponibles

```html
<!-- Ombres -->
<div class="shadow-sm">Petite ombre</div>
<div class="shadow">Ombre moyenne</div>
<div class="shadow-lg">Grande ombre</div>

<!-- Gradients -->
<div class="bg-gradient-primary">Fond bleu</div>
<div class="bg-gradient-success">Fond vert</div>
<div class="bg-gradient-danger">Fond rouge</div>

<!-- Effets hover -->
<div class="hover-lift">Soulève au survol</div>
<div class="hover-scale">Agrandit au survol</div>

<!-- Animations -->
<div class="fade-in">Apparition</div>
<div class="slide-in-left">Glisse depuis la gauche</div>
<div class="animate-on-scroll">Anime au scroll</div>
```

## 🛠️ JavaScript Utilitaire

Le fichier `public/js/utils.js` contient des fonctions pratiques :

### Formatage
```javascript
formatNumber(1234567);              // "1 234 567"
formatCurrency(50000);              // "50 000 FCFA"
formatDate('2025-11-19');           // "19/11/2025"
```

### Interactions
```javascript
// Confirmation
confirmAction('Supprimer ?', 'Irréversible', () => {
    // Action à exécuter
});

// Messages
showSuccess('Opération réussie');
showError('Erreur survenue');

// Loader
showLoader();
// ... action asynchrone ...
hideLoader();
```

### Plugins
```javascript
// DataTable
initDataTable('#ma-table', {
    pageLength: 50
});

// Select2
initSelect2('.mon-select', {
    placeholder: 'Choisir...'
});
```

### Utilitaires
```javascript
// Copier dans le presse-papier
copyToClipboard('Texte à copier');

// Scroll to top
scrollToTop();

// Animation
animateElement('.ma-card', 'fade-in');

// Debounce
const debouncedFn = debounce(maFonction, 500);

// Pourcentage
calculatePercentageChange(100, 150); // "+50.0%"
```

## 📱 Pages disponibles

### Tableau de bord (`/admin`)
- Vue d'ensemble des statistiques
- Graphiques de performance
- Activités récentes
- Alertes et notifications

### Gestion des palettes (`/admin/palettes`)
- Liste des palettes avec DataTables
- Création/édition de palettes
- Upload d'images
- Gestion des disponibilités

### Points de vente
- **Boutiques** (`/admin/boutiques`)
- **Entrepôts** (`/admin/entrepots`)
- **Usines** (`/admin/usines`)

### Catégories (`/admin/categories`)
- Gestion des catégories de produits
- Organisation hiérarchique

### Promotions (`/admin/pack-promotions`)
- Création de promotions
- Gestion des périodes
- Activation/désactivation

### Publicités (`/admin/publicites`)
- Gestion des bannières publicitaires
- Upload d'images
- Planification

### Administration
- **Utilisateurs** (`/admin/utilisateurs`)
- **Rôles** (`/admin/roles`)

### Activité
- **Transactions** (`/admin/transactions`)
- **Scans** (`/admin/scans`)

### Analytics (`/admin/analytics`)
- Statistiques détaillées
- Graphiques interactifs
- Exports de données

### Rapports (`/admin/reports`)
- Génération de rapports
- Exports PDF/Excel

## 🔐 Sécurité & Permissions

L'accès à l'interface admin est protégé par :

1. **Middleware d'authentification** (`auth`)
2. **Middleware de rôle** (`role:admin`)
3. **Permissions Spatie** pour actions spécifiques
4. **CSRF Protection** sur tous les formulaires

## 🎯 Bonnes pratiques

### 1. Utiliser les DataTables pour les listes
```javascript
initDataTable('#ma-table', {
    order: [[0, 'desc']],
    columnDefs: [
        { orderable: false, targets: [3, 4] }
    ]
});
```

### 2. Confirmer les actions destructives
```javascript
confirmAction(
    'Supprimer cet élément ?',
    'Cette action est irréversible',
    function() {
        // Supprimer...
    }
);
```

### 3. Afficher des feedbacks utilisateur
```javascript
showLoader();
fetch('/api/action')
    .then(response => response.json())
    .then(data => {
        hideLoader();
        showSuccess('Opération réussie');
    })
    .catch(error => {
        hideLoader();
        showError('Une erreur est survenue');
    });
```

### 4. Utiliser les classes CSS personnalisées
```html
<div class="card shadow-lg hover-lift animate-on-scroll">
    <div class="card-header bg-gradient-primary text-white">
        <h3 class="card-title">Titre</h3>
    </div>
    <div class="card-body">
        Contenu
    </div>
</div>
```

### 5. Initialiser Select2 sur les selects
```javascript
initSelect2('.ma-select', {
    placeholder: 'Sélectionner...',
    allowClear: true
});
```

## 📚 Documentation complète

- **CSS personnalisé** : `public/assets/css/README.md`
- **JavaScript utilitaire** : `public/js/README.md`
- **AdminLTE Documentation** : https://adminlte.io/docs/3.0/
- **Bootstrap 4 Documentation** : https://getbootstrap.com/docs/4.6/
- **DataTables Documentation** : https://datatables.net/

## 🚀 Démarrage rapide

### 1. Créer une nouvelle page admin

**Contrôleur :**
```php
// app/Http/Controllers/Admin/MonController.php
namespace App\Http\Controllers\Admin;

class MonController extends Controller
{
    public function index()
    {
        return view('admin.ma-page.index');
    }
}
```

**Route :**
```php
// routes/web.php
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/ma-page', [MonController::class, 'index'])->name('admin.ma-page');
});
```

**Vue :**
```blade
{{-- resources/views/admin/ma-page/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Ma Page')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg animate-on-scroll">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Ma Page
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Contenu -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Code JS personnalisé
    });
</script>
@endpush
```

### 2. Ajouter un lien dans le menu

Modifier `resources/views/components/menu.blade.php` :

```blade
<li class="nav-item {{ request()->is('admin/ma-page*') ? 'active' : '' }}">
    <a href="{{ route('admin.ma-page') }}" 
       class="nav-link {{ request()->is('admin/ma-page*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-star"></i>
        <p>Ma Page</p>
    </a>
</li>
```

## 🎨 Personnalisation

### Changer les couleurs principales

Modifier les variables dans `public/assets/css/style.css` :

```css
:root {
    --primary-color: #votre-couleur;
    --secondary-color: #votre-couleur;
    --accent-color: #votre-couleur;
}
```

### Ajouter des animations personnalisées

```css
@keyframes mon-animation {
    from { /* état initial */ }
    to { /* état final */ }
}

.ma-classe {
    animation: mon-animation 1s ease;
}
```

## 🐛 Débogage

### Activer les logs JavaScript
```javascript
// Dans la console navigateur
localStorage.setItem('debug', 'true');
```

### Vérifier les erreurs CSS
Utiliser l'inspecteur d'éléments du navigateur (F12)

### Vérifier les erreurs Laravel
```bash
tail -f storage/logs/laravel.log
```

## 📞 Support

Pour toute question ou problème :
- Documentation : Voir les README dans `public/assets/css/` et `public/js/`
- Code : Vérifier les commentaires dans les fichiers sources

## 📄 Licence

Copyright © 2025 AfriLoc - Tous droits réservés.

---

**Dernière mise à jour :** 19 novembre 2025
**Version :** 1.0.0

