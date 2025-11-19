# 🎨 Guide d'utilisation des styles personnalisés AfriLoc

## 📦 Fichiers créés/modifiés

### Nouveaux fichiers CSS et JavaScript
1. **`public/assets/css/style.css`** - Styles personnalisés pour AdminLTE (600+ lignes)
2. **`public/js/utils.js`** - Fonctions utilitaires JavaScript enrichies (350+ lignes)

### Documentation
1. **`public/assets/css/README.md`** - Documentation CSS complète
2. **`public/js/README.md`** - Documentation JavaScript complète
3. **`INTERFACE_ADMIN.md`** - Guide général de l'interface admin
4. **`CUSTOM_STYLES_GUIDE.md`** - Ce fichier

### Page d'exemples
1. **`resources/views/admin/exemples/ui-elements.blade.php`** - Page de démonstration
2. **`app/Http/Controllers/Admin/ExemplesController.php`** - Contrôleur
3. Route ajoutée : `/admin/exemples/ui-elements`

## 🚀 Démarrage rapide

### 1. Accéder à la page d'exemples

Une fois connecté en tant qu'admin, accédez à la page d'exemples :

```
http://localhost:8000/admin/exemples/ui-elements
```

Ou cliquez sur **"Exemples UI"** dans le menu latéral (avec le badge "Demo").

### 2. Tester les fonctionnalités

La page d'exemples contient :
- ✅ Info boxes animées
- ✅ Boutons avec actions JavaScript
- ✅ Badges et alertes
- ✅ Formulaires avec Select2
- ✅ Tableau DataTables fonctionnel
- ✅ Classes utilitaires en action
- ✅ Démonstration des fonctions JavaScript

## 🎯 Utilisation dans vos pages

### Exemple complet d'une nouvelle page admin

**1. Créer le contrôleur :**
```php
// app/Http/Controllers/Admin/MaPageController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class MaPageController extends Controller
{
    public function index()
    {
        $data = [
            'items' => collect([]),
            'stats' => []
        ];
        
        return view('admin.ma-page.index', $data);
    }
}
```

**2. Ajouter la route :**
```php
// routes/web.php
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // ... autres routes
    Route::get('/ma-page', [MaPageController::class, 'index'])->name('admin.ma-page');
});
```

**3. Créer la vue :**
```blade
{{-- resources/views/admin/ma-page/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Ma Page')

@section('content')
<div class="container-fluid">
    <!-- Stats cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-primary hover-lift">
                <div class="inner">
                    <h3>150</h3>
                    <p>Total Items</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Plus d'infos <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- Autres stats... -->
    </div>

    <!-- Tableau principal -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg animate-on-scroll">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Liste des éléments
                    </h3>
                    <div class="card-tools">
                        <button class="btn btn-sm btn-light" onclick="showCreateModal()">
                            <i class="fas fa-plus mr-1"></i>
                            Ajouter
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="items-table" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->nom }}</td>
                                <td>
                                    <span class="badge badge-success">Actif</span>
                                </td>
                                <td>{{ formatDate($item->created_at) }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="viewItem({{ $item->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" onclick="editItem({{ $item->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteItem({{ $item->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialiser DataTables
    initDataTable('#items-table', {
        order: [[0, 'desc']],
        pageLength: 25
    });
});

function deleteItem(id) {
    confirmAction(
        'Supprimer cet élément ?',
        'Cette action est irréversible',
        function() {
            showLoader();
            
            fetch(`/admin/ma-page/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                hideLoader();
                showSuccess('Élément supprimé avec succès');
                $('#items-table').DataTable().ajax.reload();
            })
            .catch(error => {
                hideLoader();
                showError('Erreur lors de la suppression');
            });
        }
    );
}
</script>
@endpush
```

**4. Ajouter au menu :**
```blade
{{-- resources/views/components/menu.blade.php --}}
<li class="nav-item {{ request()->is('admin/ma-page*') ? 'active' : '' }}">
    <a href="{{ route('admin.ma-page') }}" 
       class="nav-link {{ request()->is('admin/ma-page*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-star"></i>
        <p>Ma Page</p>
    </a>
</li>
```

## 💡 Astuces & Best Practices

### 1. Animations au scroll
Ajoutez `animate-on-scroll` à vos cards pour une apparition fluide :
```html
<div class="card shadow animate-on-scroll">
    <!-- Contenu -->
</div>
```

### 2. Hover effects
Utilisez `hover-lift` ou `hover-scale` pour des effets au survol :
```html
<div class="info-box bg-gradient-primary hover-lift">
    <!-- Contenu -->
</div>
```

### 3. Confirmation des actions
Toujours confirmer les actions destructives :
```javascript
confirmAction('Supprimer ?', 'Irréversible', () => {
    // Action...
});
```

### 4. Loader pour les actions asynchrones
```javascript
showLoader();
// Requête AJAX...
hideLoader();
showSuccess('Terminé !');
```

### 5. Formatage des données
```javascript
// Nombres
formatNumber(1234567); // "1 234 567"

// Devises
formatCurrency(50000); // "50 000 FCFA"

// Dates
formatDate('2025-11-19'); // "19/11/2025"
```

### 6. DataTables avec configuration
```javascript
initDataTable('#ma-table', {
    order: [[0, 'desc']],
    pageLength: 50,
    columnDefs: [
        { orderable: false, targets: [3, 4] }
    ]
});
```

### 7. Select2 avec AJAX
```javascript
initSelect2('#mon-select', {
    ajax: {
        url: '/api/recherche',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                q: params.term
            };
        }
    },
    minimumInputLength: 2
});
```

## 🎨 Classes CSS les plus utiles

| Classe | Description | Exemple |
|--------|-------------|---------|
| `shadow`, `shadow-sm`, `shadow-lg` | Ombres | `<div class="card shadow-lg">` |
| `rounded-lg`, `rounded-xl` | Coins arrondis | `<div class="rounded-xl">` |
| `hover-lift` | Soulève au survol | `<div class="card hover-lift">` |
| `hover-scale` | Agrandit au survol | `<div class="hover-scale">` |
| `animate-on-scroll` | Animation au scroll | `<div class="animate-on-scroll">` |
| `fade-in` | Apparition en fondu | `<div class="fade-in">` |
| `slide-in-left` | Glisse depuis la gauche | `<div class="slide-in-left">` |
| `bg-gradient-*` | Fond gradient | `<div class="bg-gradient-primary">` |
| `text-gradient-primary` | Texte gradient | `<h1 class="text-gradient-primary">` |

## 🔧 Fonctions JavaScript essentielles

### Formatage
- `formatNumber(number, locale='fr-FR')`
- `formatCurrency(amount, currency='XOF', locale='fr-FR')`
- `formatDate(date, format='short')`

### Messages
- `showSuccess(message)`
- `showError(message)`
- `confirmAction(title, text, callback)`

### UI
- `showLoader()` / `hideLoader()`
- `scrollToTop()`
- `animateElement(element, animationClass)`

### Plugins
- `initDataTable(selector, options)`
- `initSelect2(selector, options)`
- `initTooltips()`
- `initPopovers()`

### Utilitaires
- `copyToClipboard(text, button)`
- `calculatePercentageChange(oldValue, newValue)`
- `debounce(func, wait=300)`

## 📱 Responsive Design

Toutes les classes et composants sont responsive :
- Mobile-first approach
- Breakpoints Bootstrap standard
- Animations désactivées sur mobile si nécessaire

## 🐛 Débogage

### Console JavaScript
```javascript
// Activer les logs détaillés
localStorage.setItem('debug', 'true');
```

### Vérifier les styles
Utiliser l'inspecteur (F12) pour voir les classes appliquées

### Tester les animations
Recharger la page ou utiliser `animateElement()` manuellement

## 📚 Références

- **Styles CSS** : `public/assets/css/README.md`
- **JavaScript** : `public/js/README.md`
- **Interface Admin** : `INTERFACE_ADMIN.md`
- **AdminLTE** : https://adminlte.io/docs/3.0/
- **Bootstrap 4** : https://getbootstrap.com/docs/4.6/
- **DataTables** : https://datatables.net/
- **Select2** : https://select2.org/
- **SweetAlert2** : https://sweetalert2.github.io/

## 🎓 Formation

Pour vous familiariser avec les fonctionnalités :

1. **Visitez la page d'exemples** : `/admin/exemples/ui-elements`
2. **Inspectez le code source** de cette page
3. **Testez les interactions** (boutons, formulaires, etc.)
4. **Consultez les README** pour plus de détails
5. **Copiez les exemples** dans vos propres pages

## ✨ Fonctionnalités automatiques

Ces fonctionnalités sont activées automatiquement :

- ✅ Tooltips Bootstrap (`data-toggle="tooltip"`)
- ✅ Popovers Bootstrap (`data-toggle="popover"`)
- ✅ Bouton "Retour en haut" (apparaît après 300px de scroll)
- ✅ Animations au scroll pour `.animate-on-scroll`
- ✅ Pulse animation sur les badges navbar
- ✅ Float animation sur les icônes d'info-boxes

## 🎯 Checklist pour une nouvelle page

- [ ] Créer le contrôleur
- [ ] Ajouter la route
- [ ] Créer la vue avec `@extends('layouts.admin')`
- [ ] Utiliser les classes CSS personnalisées
- [ ] Initialiser DataTables si nécessaire
- [ ] Initialiser Select2 si nécessaire
- [ ] Ajouter des confirmations pour actions destructives
- [ ] Utiliser showLoader/hideLoader pour AJAX
- [ ] Ajouter au menu sidebar
- [ ] Tester sur mobile
- [ ] Vérifier les animations

---

**Créé le :** 19 novembre 2025  
**Version :** 1.0.0  
**Auteur :** AfriLoc Development Team

