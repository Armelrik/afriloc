# 📁 Assets AfriLoc Admin

## 📋 Contenu du dossier

### CSS
- **`css/style.css`** - Styles personnalisés pour l'interface AdminLTE
  - 600+ lignes de CSS moderne
  - Variables CSS personnalisables
  - Animations et transitions fluides
  - Classes utilitaires pratiques
  - Design responsive complet

### Documentation
- **`css/README.md`** - Documentation complète des styles CSS

## 🚀 Utilisation

Les styles sont automatiquement chargés dans toutes les pages admin via le layout `layouts/admin.blade.php`.

### Inclure dans votre template

Si vous créez un nouveau layout, incluez le fichier CSS :

```blade
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
```

## 🎨 Styles disponibles

### Variables CSS
```css
--primary-color: #3498db
--secondary-color: #2c3e50
--accent-color: #e74c3c
--success-color: #27ae60
--warning-color: #f39c12
--danger-color: #e74c3c
```

### Classes principales

#### Ombres
- `shadow-sm` - Petite ombre
- `shadow` - Ombre moyenne
- `shadow-lg` - Grande ombre

#### Coins arrondis
- `rounded-lg` - Arrondi 12px
- `rounded-xl` - Arrondi 16px

#### Effets hover
- `hover-lift` - Soulève l'élément au survol
- `hover-scale` - Agrandit l'élément au survol

#### Animations
- `fade-in` - Apparition en fondu
- `slide-in-left` - Glissement depuis la gauche
- `slide-in-right` - Glissement depuis la droite
- `animate-on-scroll` - Animation lors du scroll

#### Backgrounds gradient
- `bg-gradient-primary` - Bleu
- `bg-gradient-success` - Vert
- `bg-gradient-danger` - Rouge
- `bg-gradient-warning` - Orange
- `bg-gradient-info` - Bleu clair
- `bg-gradient-dark` - Gris foncé

#### Texte gradient
- `text-gradient-primary` - Texte avec effet gradient

## 📦 Composants stylisés

### Cards
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

### Info Boxes
```html
<div class="info-box bg-gradient-primary hover-lift">
    <span class="info-box-icon">
        <i class="fas fa-users"></i>
    </span>
    <div class="info-box-content">
        <span class="info-box-text">UTILISATEURS</span>
        <span class="info-box-number">1,234</span>
    </div>
</div>
```

### Small Boxes
```html
<div class="small-box bg-gradient-success hover-lift">
    <div class="inner">
        <h3>150</h3>
        <p>Nouveaux clients</p>
    </div>
    <div class="icon">
        <i class="fas fa-shopping-cart"></i>
    </div>
    <a href="#" class="small-box-footer">
        Plus d'infos <i class="fas fa-arrow-circle-right"></i>
    </a>
</div>
```

### Boutons
```html
<button class="btn btn-primary">
    <i class="fas fa-save mr-2"></i>
    Enregistrer
</button>
```

### Alerts
```html
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle mr-2"></i>
    Opération réussie !
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
```

### Badges
```html
<span class="badge badge-primary">Primary</span>
<span class="badge badge-success">Success</span>
<span class="badge badge-danger">Danger</span>
```

## 🎯 Exemples pratiques

### Page avec stats
```html
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-primary hover-lift">
                <div class="inner">
                    <h3>150</h3>
                    <p>Total</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Détails <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
```

### Tableau moderne
```html
<div class="card shadow-lg animate-on-scroll">
    <div class="card-header bg-gradient-dark text-white">
        <h3 class="card-title">
            <i class="fas fa-table mr-2"></i>
            Liste
        </h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover">
            <!-- Contenu du tableau -->
        </table>
    </div>
</div>
```

## 🔧 Personnalisation

Pour modifier les couleurs principales, éditez `css/style.css` :

```css
:root {
    --primary-color: #votre-couleur;
    --secondary-color: #votre-couleur;
    /* etc... */
}
```

## 📱 Responsive

Tous les styles sont responsive avec des breakpoints adaptés :
- Mobile : < 768px
- Tablet : 768px - 1024px
- Desktop : > 1024px

## 🖨️ Print

Des styles d'impression sont inclus pour masquer les éléments inutiles lors de l'impression :
- Sidebar masquée
- Header masqué
- Footer masqué
- Ombres supprimées

## 📚 Documentation complète

- **Styles CSS** : `css/README.md`
- **JavaScript** : `../js/README.md`
- **Guide général** : Racine du projet `/INTERFACE_ADMIN.md`
- **Guide d'utilisation** : Racine du projet `/CUSTOM_STYLES_GUIDE.md`

## 🎓 Page d'exemples

Une page de démonstration complète est disponible :
```
http://localhost:8000/admin/exemples/ui-elements
```

Accessible via le menu admin : **Exemples UI**

## 📞 Support

Pour toute question :
- Consultez la documentation dans `css/README.md`
- Visitez la page d'exemples
- Inspectez le code source des exemples

---

**Dernière mise à jour :** 19 novembre 2025  
**Version :** 1.0.0  
**Copyright ©** 2025 AfriLoc - Tous droits réservés

