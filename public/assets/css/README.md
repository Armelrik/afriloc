# AfriLoc Admin - Documentation des Styles Personnalisés

## 📋 Vue d'ensemble

Ce fichier CSS personnalisé (`style.css`) améliore l'interface AdminLTE avec des styles modernes, des animations fluides et une meilleure expérience utilisateur.

## 🎨 Variables CSS personnalisées

Les couleurs principales sont définies comme variables CSS pour faciliter la personnalisation :

```css
--primary-color: #3498db
--secondary-color: #2c3e50
--accent-color: #e74c3c
--success-color: #27ae60
--warning-color: #f39c12
--danger-color: #e74c3c
--info-color: #3498db
```

## 🚀 Fonctionnalités principales

### 1. **Navbar améliorée**
- Effets de survol fluides sur les liens
- Animation pulse sur les badges de notification
- Barre de recherche avec effets de focus
- Menu utilisateur stylisé avec ombres

### 2. **Sidebar moderne**
- Dégradé de couleurs pour le fond
- Animations au survol des éléments de menu
- Items actifs avec gradient et ombre
- Menus déroulants (treeview) avec fond semi-transparent

### 3. **Cards & Boxes**
- Effets de lift au survol
- Coins arrondis (12px)
- Ombres douces et modernes
- Info-boxes avec icônes flottantes animées

### 4. **Boutons**
- Gradients de couleurs
- Effets de hover avec translation
- Ombres dynamiques
- Support des icônes Font Awesome

### 5. **Alerts**
- Design moderne avec gradients
- Animation d'apparition (slideInDown)
- Bordure gauche colorée
- Bouton de fermeture amélioré

### 6. **Tables**
- En-têtes avec dégradé dark
- Effet de hover sur les lignes
- Pagination stylisée
- Support complet de DataTables

### 7. **Formulaires**
- Inputs avec bordures colorées au focus
- Select2 intégré avec thème Bootstrap 4
- Labels avec poids de police optimisé
- Coins arrondis uniformes

### 8. **Badges**
- Gradients de couleurs
- Coins arrondis
- Police en gras
- Tailles optimisées

## 🎭 Classes utilitaires

### Ombres
```html
<div class="shadow-sm">Ombre petite</div>
<div class="shadow">Ombre moyenne</div>
<div class="shadow-lg">Ombre grande</div>
```

### Coins arrondis
```html
<div class="rounded-lg">Arrondi 12px</div>
<div class="rounded-xl">Arrondi 16px</div>
```

### Backgrounds gradient
```html
<div class="bg-gradient-primary">Bleu</div>
<div class="bg-gradient-success">Vert</div>
<div class="bg-gradient-danger">Rouge</div>
<div class="bg-gradient-warning">Orange</div>
<div class="bg-gradient-info">Bleu clair</div>
<div class="bg-gradient-dark">Gris foncé</div>
```

### Texte gradient
```html
<h1 class="text-gradient-primary">Titre avec gradient</h1>
```

### Effets hover
```html
<div class="hover-lift">Soulève au survol</div>
<div class="hover-scale">Agrandit au survol</div>
```

## 🎬 Animations

### Classes d'animation
```html
<div class="fade-in">Apparition en fondu</div>
<div class="slide-in-left">Glissement depuis la gauche</div>
<div class="slide-in-right">Glissement depuis la droite</div>
```

### Animation au scroll
Pour animer un élément lors du scroll, ajoutez la classe `animate-on-scroll` :
```html
<div class="card animate-on-scroll">
    <!-- Contenu -->
</div>
```

## 📱 Responsive Design

Le CSS est entièrement responsive avec des breakpoints pour mobile :

- Réduction de la taille des polices sur mobile
- Adaptation des info-boxes et small-boxes
- Padding ajusté pour les cards

## 🖨️ Styles d'impression

Des styles spécifiques sont appliqués lors de l'impression :
- Masquage de la sidebar, header et footer
- Suppression des ombres
- Bordures noires pour les cards

## 💡 Conseils d'utilisation

1. **Combiner les classes** : Vous pouvez combiner plusieurs classes utilitaires
   ```html
   <div class="card shadow-lg rounded-xl hover-lift">
   ```

2. **Animations** : Utilisez `animate-on-scroll` pour les éléments que vous voulez animer au défilement

3. **Badges animés** : Les badges navbar ont une animation pulse automatique

4. **Icons flottantes** : Les icônes dans les info-boxes ont une animation float automatique

## 🔧 Personnalisation

Pour personnaliser les couleurs, modifiez les variables CSS au début du fichier :

```css
:root {
    --primary-color: #votre-couleur;
    --transition-speed: 0.5s; /* Vitesse des transitions */
}
```

## 🌐 Compatibilité

Compatible avec :
- AdminLTE 3.x
- Bootstrap 4.x
- Font Awesome 5.x
- DataTables
- Select2
- SweetAlert2

## 📄 Licence

Ce fichier CSS fait partie du projet AfriLoc Admin.
Copyright © 2025 AfriLoc - Tous droits réservés.

