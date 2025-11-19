# AfriLoc Admin - Documentation JavaScript Utilitaire

## 📋 Vue d'ensemble

Le fichier `utils.js` contient des fonctions utilitaires JavaScript pour améliorer l'expérience utilisateur de l'interface admin AfriLoc.

## 🛠️ Fonctions disponibles

### 1. **copyToClipboard(text, button)**
Copie du texte dans le presse-papier avec feedback visuel.

```javascript
// Utilisation basique
copyToClipboard('Texte à copier');

// Avec bouton pour feedback visuel
const btn = document.getElementById('mon-bouton');
copyToClipboard('Texte à copier', btn);
```

**Paramètres :**
- `text` (string) : Le texte à copier
- `button` (HTMLElement, optionnel) : Bouton qui affichera le feedback

---

### 2. **formatNumber(number, locale)**
Formate un nombre avec séparateurs de milliers.

```javascript
formatNumber(1234567);           // "1 234 567"
formatNumber(1234567, 'en-US');  // "1,234,567"
```

**Paramètres :**
- `number` (number) : Le nombre à formater
- `locale` (string, défaut: 'fr-FR') : La locale

---

### 3. **formatCurrency(amount, currency, locale)**
Formate un montant en devise.

```javascript
formatCurrency(50000);                    // "50 000 FCFA"
formatCurrency(50000, 'EUR');             // "50 000 €"
formatCurrency(50000, 'USD', 'en-US');    // "$50,000"
```

**Paramètres :**
- `amount` (number) : Le montant
- `currency` (string, défaut: 'XOF') : Code devise ISO
- `locale` (string, défaut: 'fr-FR') : La locale

---

### 4. **formatDate(date, format)**
Formate une date selon le format spécifié.

```javascript
formatDate('2025-11-19');              // "19/11/2025"
formatDate('2025-11-19', 'medium');    // "19 nov. 2025"
formatDate('2025-11-19', 'long');      // "mercredi 19 novembre 2025"
```

**Paramètres :**
- `date` (string|Date) : La date à formater
- `format` (string, défaut: 'short') : 'short', 'medium' ou 'long'

---

### 5. **confirmAction(title, text, callback)**
Affiche une confirmation avec SweetAlert2 ou confirm natif.

```javascript
confirmAction(
    'Supprimer cet élément ?',
    'Cette action est irréversible',
    function() {
        // Action à exécuter si confirmé
        console.log('Supprimé !');
    }
);
```

**Paramètres :**
- `title` (string) : Titre de la confirmation
- `text` (string) : Texte descriptif
- `callback` (Function) : Fonction à exécuter si confirmé

---

### 6. **showSuccess(message)**
Affiche un message de succès.

```javascript
showSuccess('Enregistrement réussi !');
```

**Utilise :** SweetAlert2 > Toastr > alert()

---

### 7. **showError(message)**
Affiche un message d'erreur.

```javascript
showError('Une erreur est survenue');
```

**Utilise :** SweetAlert2 > Toastr > alert()

---

### 8. **initDataTable(selector, options)**
Initialise DataTables avec configuration française par défaut.

```javascript
// Configuration par défaut
initDataTable('#ma-table');

// Avec options personnalisées
initDataTable('#ma-table', {
    pageLength: 50,
    order: [[0, 'desc']],
    columnDefs: [
        { orderable: false, targets: [4, 5] }
    ]
});
```

**Paramètres :**
- `selector` (string) : Sélecteur CSS de la table
- `options` (object, optionnel) : Options DataTables supplémentaires

**Configuration par défaut :**
- Langue française
- 25 lignes par page
- Responsive activé
- AutoWidth désactivé

---

### 9. **initSelect2(selector, options)**
Initialise Select2 avec configuration par défaut.

```javascript
// Configuration par défaut
initSelect2('.mon-select');

// Avec options personnalisées
initSelect2('.mon-select', {
    placeholder: 'Choisir une option',
    minimumInputLength: 2,
    ajax: {
        url: '/api/recherche',
        dataType: 'json'
    }
});
```

**Paramètres :**
- `selector` (string) : Sélecteur CSS du select
- `options` (object, optionnel) : Options Select2 supplémentaires

**Configuration par défaut :**
- Thème Bootstrap 4
- Largeur 100%
- Langue française
- AllowClear activé

---

### 10. **showLoader() / hideLoader()**
Affiche/masque un spinner de chargement fullscreen.

```javascript
// Afficher le loader avant une requête
showLoader();

fetch('/api/data')
    .then(response => response.json())
    .then(data => {
        // Traiter les données
        hideLoader(); // Masquer le loader
    })
    .catch(error => {
        hideLoader();
        showError('Erreur de chargement');
    });
```

---

### 11. **scrollToTop()**
Fait défiler la page vers le haut en douceur.

```javascript
scrollToTop();
```

Un bouton "Retour en haut" est automatiquement ajouté et apparaît après 300px de scroll.

---

### 12. **animateElement(element, animationClass)**
Ajoute une animation à un élément.

```javascript
// Avec sélecteur
animateElement('.ma-card', 'fade-in');

// Avec élément DOM
const el = document.getElementById('mon-element');
animateElement(el, 'slide-in-left');
```

**Animations disponibles :**
- `fade-in`
- `slide-in-left`
- `slide-in-right`

---

### 13. **calculatePercentageChange(oldValue, newValue)**
Calcule le pourcentage de variation entre deux valeurs.

```javascript
calculatePercentageChange(100, 150);  // "+50.0%"
calculatePercentageChange(100, 80);   // "-20.0%"
calculatePercentageChange(0, 50);     // "+100%"
```

**Paramètres :**
- `oldValue` (number) : Ancienne valeur
- `newValue` (number) : Nouvelle valeur

**Retourne :** String avec signe et pourcentage

---

### 14. **debounce(func, wait)**
Débounce une fonction (limite le nombre d'appels).

```javascript
// Recherche avec debounce de 500ms
const searchInput = document.getElementById('search');
const debouncedSearch = debounce(function(value) {
    console.log('Recherche:', value);
    // Appel API...
}, 500);

searchInput.addEventListener('input', (e) => {
    debouncedSearch(e.target.value);
});
```

**Paramètres :**
- `func` (Function) : Fonction à débouncer
- `wait` (number, défaut: 300) : Temps d'attente en ms

---

### 15. **initTooltips() / initPopovers()**
Initialise les tooltips et popovers Bootstrap.

```javascript
// Initialisation manuelle (déjà fait automatiquement)
initTooltips();
initPopovers();
```

**HTML :**
```html
<button data-toggle="tooltip" title="Mon tooltip">Hover me</button>
<button data-toggle="popover" data-content="Contenu">Click me</button>
```

---

## 🚀 Initialisation automatique

Ces fonctionnalités sont activées automatiquement au chargement :

1. **Tooltips et Popovers** : Tous les éléments avec `data-toggle="tooltip"` ou `data-toggle="popover"`

2. **Bouton Scroll to Top** : Apparaît après 300px de scroll

3. **Animation au scroll** : Tous les éléments avec la classe `animate-on-scroll`

## 💡 Exemples d'utilisation complète

### Exemple 1 : Suppression avec confirmation
```javascript
document.getElementById('btn-delete').addEventListener('click', function() {
    confirmAction(
        'Supprimer cet enregistrement ?',
        'Cette action ne peut pas être annulée',
        function() {
            showLoader();
            fetch('/api/delete/123', { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    hideLoader();
                    showSuccess('Enregistrement supprimé avec succès');
                    // Recharger le tableau
                    $('#ma-table').DataTable().ajax.reload();
                })
                .catch(error => {
                    hideLoader();
                    showError('Erreur lors de la suppression');
                });
        }
    );
});
```

### Exemple 2 : Formulaire avec validation
```javascript
document.getElementById('mon-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    showLoader();
    
    fetch('/api/save', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        hideLoader();
        showSuccess('Données enregistrées avec succès');
        this.reset();
    })
    .catch(error => {
        hideLoader();
        showError('Erreur lors de l\'enregistrement');
    });
});
```

### Exemple 3 : Recherche avec debounce
```javascript
const searchInput = document.getElementById('search');
const resultsDiv = document.getElementById('results');

const performSearch = debounce(function(query) {
    if (query.length < 3) return;
    
    showLoader();
    fetch(`/api/search?q=${query}`)
        .then(response => response.json())
        .then(data => {
            hideLoader();
            // Afficher les résultats
            resultsDiv.innerHTML = data.map(item => 
                `<div class="result-item">${item.name}</div>`
            ).join('');
        })
        .catch(error => {
            hideLoader();
            showError('Erreur de recherche');
        });
}, 500);

searchInput.addEventListener('input', (e) => {
    performSearch(e.target.value);
});
```

## 🔌 Dépendances

- **jQuery** : Pour DataTables, Select2 et Bootstrap
- **SweetAlert2** (optionnel) : Pour les confirmations modernes
- **Toastr** (optionnel) : Pour les notifications toast
- **DataTables** (optionnel) : Pour les tableaux avancés
- **Select2** (optionnel) : Pour les sélecteurs améliorés

## 🌐 Compatibilité navigateurs

- Chrome/Edge (dernières versions)
- Firefox (dernières versions)
- Safari 12+
- IE11 (support limité)

## 📄 Licence

Ce fichier JavaScript fait partie du projet AfriLoc Admin.
Copyright © 2025 AfriLoc - Tous droits réservés.

