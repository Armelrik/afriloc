# 🔐 Guide de l'Interface Admin AfriLoc

## 📋 Vue d'ensemble

L'interface administrateur d'AfriLoc a été entièrement revue avec **AdminLTE 3** et **Bootstrap 4** pour offrir une expérience moderne, professionnelle et intuitive.

## ✨ Nouveautés

### 1. **Page de connexion admin dédiée**
- URL : `/admin/login`
- Design moderne avec gradient et animations
- Formulaire sécurisé avec validation
- Message d'erreur stylisé
- Option "Se souvenir de moi"
- Protection contre les accès non autorisés

### 2. **Toutes les vues admin mises à jour**
Toutes les pages admin utilisent maintenant le layout AdminLTE :
- ✅ Dashboard (`/admin`)
- ✅ Propriétés (`/admin/properties`)
- ✅ Réservations (`/admin/bookings`)
- ✅ Promoteurs (`/admin/promoters`)
- ✅ Contacts (`/admin/contacts`)
- ✅ Paiements (`/admin/payments`)
- ✅ Renouvellements (`/admin/renewals`)
- ✅ Maintenance (`/admin/maintenance`)
- ✅ Exemples UI (`/admin/exemples/ui-elements`)

### 3. **Layout AdminLTE complet**
Structure de l'interface :
```
resources/views/
├── layouts/
│   └── admin.blade.php          (Layout principal)
├── components/
│   ├── header.blade.php         (Navbar avec notifications)
│   ├── menu.blade.php           (Sidebar avec navigation)
│   └── footer.blade.php         (Footer)
└── admin/
    └── auth/
        └── login.blade.php      (Page de connexion admin)
```

## 🚀 Utilisation

### Connexion en tant qu'administrateur

1. **Accéder à la page de connexion :**
   ```
   http://localhost:8000/admin/login
   ```

2. **Identifiants de test :**
   - Email : `admin@admin.com`
   - Mot de passe : `password` (à vérifier dans votre base de données)

3. **Après connexion :**
   - Redirection automatique vers `/admin` (dashboard)
   - Menu latéral avec toutes les sections
   - Notifications en temps réel
   - Statistiques et graphiques

### Navigation

#### Sidebar (Menu latéral)
Le menu contient toutes les sections principales :

📊 **Tableau de bord** - Vue d'ensemble et statistiques
📈 **Analytics** - Analyses détaillées
🏠 **Palette** - Gestion des propriétés
🏪 **Points de vente** - Boutiques, Entrepôts, Usines
🏷️ **Catégories** - Gestion des catégories
💰 **Promotions** - Offres promotionnelles
📢 **Publicités** - Gestion des bannières
👥 **Administration** - Utilisateurs et rôles
📊 **Activité** - Transactions et scans
📄 **Rapports** - Génération de rapports
🎨 **Exemples UI** - Page de démonstration
⚙️ **Paramètres** - Configuration
🚪 **Déconnexion** - Se déconnecter

#### Header (Barre supérieure)
- **Recherche** - Recherche globale
- **Messages** - Voir les messages
- **Notifications** - Alertes importantes
- **Plein écran** - Basculer en mode plein écran
- **Profil** - Menu utilisateur

## 🎨 Design & Styles

### Classes Bootstrap 4 utilisées

```html
<!-- Cards -->
<div class="card shadow-lg animate-on-scroll">
    <div class="card-header bg-gradient-primary text-white">
        <h3 class="card-title">Titre</h3>
    </div>
    <div class="card-body">
        Contenu
    </div>
</div>

<!-- Small boxes (Stats) -->
<div class="small-box bg-gradient-primary hover-lift">
    <div class="inner">
        <h3>150</h3>
        <p>Total</p>
    </div>
    <div class="icon">
        <i class="fas fa-shopping-cart"></i>
    </div>
    <a href="#" class="small-box-footer">
        Plus d'infos <i class="fas fa-arrow-circle-right"></i>
    </a>
</div>

<!-- Tables -->
<table class="table table-bordered table-striped table-hover">
    <thead class="bg-light">
        <tr>
            <th>Colonne 1</th>
            <th>Colonne 2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Donnée 1</td>
            <td>Donnée 2</td>
        </tr>
    </tbody>
</table>

<!-- Buttons -->
<button class="btn btn-primary">
    <i class="fas fa-save mr-2"></i>
    Enregistrer
</button>

<!-- Badges -->
<span class="badge badge-success">
    <i class="fas fa-check-circle mr-1"></i>
    Actif
</span>

<!-- Alerts -->
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle mr-2"></i>
    Message de succès
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
```

### Classes personnalisées

En plus de Bootstrap 4, vous pouvez utiliser les classes personnalisées d'AfriLoc :

```html
<!-- Effets hover -->
<div class="hover-lift">Soulève au survol</div>
<div class="hover-scale">Agrandit au survol</div>

<!-- Animations -->
<div class="animate-on-scroll">Anime au scroll</div>
<div class="fade-in">Apparition en fondu</div>

<!-- Ombres -->
<div class="shadow-lg">Grande ombre</div>

<!-- Gradients -->
<div class="bg-gradient-primary">Fond avec gradient</div>
```

## 📊 Pages principales

### 1. Dashboard (`/admin`)
- **Stats cards** - Propriétés, Réservations, Revenus, Utilisateurs
- **Graphiques** - Revenus mensuels, Réservations par statut
- **Tableaux** - Réservations récentes, Propriétés récentes
- **Info boxes** - Renouvellements, Maintenance, Promoteurs, Contacts

### 2. Propriétés (`/admin/properties`)
- Liste complète avec images
- Filtres par type et statut
- Actions : Voir, Modifier, Supprimer
- Pagination

### 3. Réservations (`/admin/bookings`)
- Liste des réservations
- Filtres par statut
- Changement de statut direct
- Détails client et propriété

### 4. Promoteurs (`/admin/promoters`)
- Gestion des demandes
- Approuver/Rejeter/Suspendre
- Filtres par statut
- Vue détaillée

### 5. Paiements (`/admin/payments`)
- Liste des transactions
- Filtres par statut et mode
- Validation/Remboursement
- Références de paiement

### 6. Renouvellements (`/admin/renewals`)
- Demandes de renouvellement
- Approuver/Rejeter
- Type manuel/automatique
- Montants et périodes

### 7. Maintenance (`/admin/maintenance`)
- Demandes de maintenance
- Priorités (Urgente, Haute, Moyenne, Basse)
- Statuts (En attente, En cours, Terminé)
- Catégories (Plomberie, Électricité, etc.)

### 8. Contacts (`/admin/contacts`)
- Messages de contact
- Marquer comme lu
- Répondre aux messages
- Supprimer

### 9. Exemples UI (`/admin/exemples/ui-elements`)
- Page de démonstration complète
- Info boxes animées
- Boutons avec actions JS
- Formulaires avec Select2
- Tableau DataTables
- Classes CSS en action

## 🔒 Sécurité & Redirections

### Middleware
- **`auth`** - Vérifie l'authentification
- **`role:admin`** - Vérifie le rôle administrateur

### Redirections automatiques

**Lors de la connexion :**
```php
// Si admin
return redirect()->route('admin.dashboard');

// Si promoteur
return redirect()->route('promoter.dashboard');

// Si client
return redirect()->route('client.dashboard');
```

**En cas d'accès non autorisé :**
- Non connecté → `/admin/login`
- Rôle incorrect → Erreur 403

### Déconnexion
- Formulaire dans le sidebar
- Route : `POST /admin/logout`
- Redirection vers `/admin/login`

## 🛠️ Développement

### Créer une nouvelle page admin

**1. Créer le composant Livewire (optionnel) :**
```bash
php artisan make:livewire Admin/MaPage/MaPageList
```

**2. Créer la vue Blade :**
```blade
{{-- resources/views/livewire/admin/ma-page/ma-page-list.blade.php --}}
@section('title', 'Ma Page')

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0">
                <i class="fas fa-star mr-2"></i>
                Ma Page
            </h1>
        </div>
    </div>

    <!-- Contenu -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg animate-on-scroll">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2"></i>
                        Liste
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Votre contenu ici -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    initTooltips();
});
</script>
@endpush
```

**3. Ajouter la route :**
```php
// routes/web.php
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // ...
    Route::get('/ma-page', \App\Livewire\Admin\MaPage\MaPageList::class)->name('admin.ma-page');
});
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

## 📚 Documentation complémentaire

- **Styles CSS** : `public/assets/css/README.md`
- **JavaScript** : `public/js/README.md`
- **Guide des styles** : `CUSTOM_STYLES_GUIDE.md`
- **Interface admin générale** : `INTERFACE_ADMIN.md`

## 🐛 Débogage

### Problèmes courants

**1. Page blanche après connexion**
```bash
php artisan route:clear
php artisan view:clear
php artisan config:clear
```

**2. Erreur 403 après connexion**
- Vérifier que l'utilisateur a le rôle `admin`
- Vérifier dans la base de données : `role_user` et `roles`

**3. CSS/JS ne se charge pas**
```bash
npm run build
# ou
npm run dev
```

**4. Redirection incorrecte**
- Vérifier `app/Http/Middleware/RoleMiddleware.php`
- Vérifier `app/Http/Controllers/Admin/AdminAuthController.php`

## ✅ Checklist de déploiement

- [ ] Tester la connexion admin
- [ ] Vérifier toutes les pages admin
- [ ] Tester les filtres et recherches
- [ ] Vérifier les permissions
- [ ] Tester les redirections
- [ ] Vérifier les graphiques (Chart.js)
- [ ] Tester sur mobile
- [ ] Vérifier les traductions
- [ ] Tester la déconnexion
- [ ] Vérifier les logs d'erreur

## 📞 Support

Pour toute question ou problème :
- Consulter la documentation dans `/public/assets/css/README.md`
- Voir la page d'exemples : `/admin/exemples/ui-elements`
- Vérifier les logs Laravel : `storage/logs/laravel.log`

---

**Dernière mise à jour :** 19 novembre 2025  
**Version :** 1.0.0  
**Auteur :** AfriLoc Development Team

