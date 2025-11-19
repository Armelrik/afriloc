/**
 * Fonction utilitaire pour copier du texte dans le presse-papier
 * @param {string} text - Le texte à copier
 * @param {HTMLElement} button - L'élément bouton qui a déclenché l'action (optionnel)
 */
function copyToClipboard(text, button = null) {
    // Créer un élément textarea temporaire
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.setAttribute('readonly', '');
    textarea.style.position = 'absolute';
    textarea.style.left = '-9999px';
    document.body.appendChild(textarea);
    
    // Sélectionner le texte
    textarea.select();
    
    try {
        // Exécuter la commande de copie
        const successful = document.execCommand('copy');
        const message = successful ? 'Copié dans le presse-papier' : 'Échec de la copie';
        
        // Afficher un message de retour visuel
        if (button) {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check"></i> Copié !';
            button.classList.add('text-success');
            
            // Réinitialiser le bouton après 2 secondes
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('text-success');
            }, 2000);
        } else {
            // Utiliser Toastr si disponible
            if (typeof toastr !== 'undefined') {
                toastr.success(message);
            } else {
                console.log(message);
            }
        }
    } catch (err) {
        console.error('Erreur lors de la copie :', err);
        
        // Fallback pour les navigateurs plus anciens
        if (typeof toastr !== 'undefined') {
            toastr.error('Votre navigateur ne supporte pas cette fonctionnalité');
        }
    }
    
    // Nettoyer
    document.body.removeChild(textarea);
}

/**
 * Formater un nombre avec séparateurs de milliers
 * @param {number} number - Le nombre à formater
 * @param {string} locale - La locale (défaut: 'fr-FR')
 * @returns {string} Nombre formaté
 */
function formatNumber(number, locale = 'fr-FR') {
    return new Intl.NumberFormat(locale).format(number);
}

/**
 * Formater une devise
 * @param {number} amount - Le montant
 * @param {string} currency - La devise (défaut: 'XOF')
 * @param {string} locale - La locale (défaut: 'fr-FR')
 * @returns {string} Montant formaté
 */
function formatCurrency(amount, currency = 'XOF', locale = 'fr-FR') {
    return new Intl.NumberFormat(locale, {
        style: 'currency',
        currency: currency,
        minimumFractionDigits: 0
    }).format(amount);
}

/**
 * Formater une date
 * @param {string|Date} date - La date à formater
 * @param {string} format - Le format (défaut: 'short')
 * @returns {string} Date formatée
 */
function formatDate(date, format = 'short') {
    const d = new Date(date);
    const options = {
        short: { year: 'numeric', month: '2-digit', day: '2-digit' },
        medium: { year: 'numeric', month: 'short', day: 'numeric' },
        long: { year: 'numeric', month: 'long', day: 'numeric', weekday: 'long' }
    };
    return new Intl.DateTimeFormat('fr-FR', options[format]).format(d);
}

/**
 * Confirmer une action avec SweetAlert2
 * @param {string} title - Titre de la confirmation
 * @param {string} text - Texte descriptif
 * @param {Function} callback - Fonction à exécuter si confirmé
 */
function confirmAction(title, text, callback) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, confirmer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                callback();
            }
        });
    } else if (confirm(`${title}\n${text}`)) {
        callback();
    }
}

/**
 * Afficher un message de succès
 * @param {string} message - Le message à afficher
 */
function showSuccess(message) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: message,
            timer: 3000,
            showConfirmButton: false
        });
    } else if (typeof toastr !== 'undefined') {
        toastr.success(message);
    } else {
        alert(message);
    }
}

/**
 * Afficher un message d'erreur
 * @param {string} message - Le message à afficher
 */
function showError(message) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: message
        });
    } else if (typeof toastr !== 'undefined') {
        toastr.error(message);
    } else {
        alert(message);
    }
}

/**
 * Initialiser les DataTables avec configuration par défaut
 * @param {string} selector - Sélecteur de la table
 * @param {object} options - Options supplémentaires
 */
function initDataTable(selector, options = {}) {
    if (typeof $.fn.DataTable !== 'undefined') {
        const defaultOptions = {
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json'
            },
            pageLength: 25,
            responsive: true,
            autoWidth: false,
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
            ...options
        };
        return $(selector).DataTable(defaultOptions);
    }
}

/**
 * Initialiser Select2 avec configuration par défaut
 * @param {string} selector - Sélecteur de l'élément select
 * @param {object} options - Options supplémentaires
 */
function initSelect2(selector, options = {}) {
    if (typeof $.fn.select2 !== 'undefined') {
        const defaultOptions = {
            theme: 'bootstrap4',
            width: '100%',
            language: 'fr',
            placeholder: 'Sélectionner une option',
            allowClear: true,
            ...options
        };
        return $(selector).select2(defaultOptions);
    }
}

/**
 * Afficher un loader/spinner
 */
function showLoader() {
    if (!document.getElementById('custom-loader')) {
        const loader = document.createElement('div');
        loader.id = 'custom-loader';
        loader.className = 'spinner-overlay';
        loader.innerHTML = `
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Chargement...</span>
            </div>
        `;
        document.body.appendChild(loader);
    }
}

/**
 * Masquer le loader/spinner
 */
function hideLoader() {
    const loader = document.getElementById('custom-loader');
    if (loader) {
        loader.remove();
    }
}

/**
 * Faire défiler vers le haut de la page
 */
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

/**
 * Ajouter une classe d'animation à un élément
 * @param {HTMLElement|string} element - L'élément ou son sélecteur
 * @param {string} animationClass - Classe d'animation (ex: 'fade-in')
 */
function animateElement(element, animationClass) {
    const el = typeof element === 'string' ? document.querySelector(element) : element;
    if (el) {
        el.classList.add(animationClass);
        el.addEventListener('animationend', () => {
            el.classList.remove(animationClass);
        }, { once: true });
    }
}

/**
 * Calculer le pourcentage de variation
 * @param {number} oldValue - Ancienne valeur
 * @param {number} newValue - Nouvelle valeur
 * @returns {string} Pourcentage formaté avec signe
 */
function calculatePercentageChange(oldValue, newValue) {
    if (oldValue === 0) return '+100%';
    const change = ((newValue - oldValue) / oldValue) * 100;
    const sign = change > 0 ? '+' : '';
    return `${sign}${change.toFixed(1)}%`;
}

/**
 * Débounce une fonction
 * @param {Function} func - La fonction à débouncer
 * @param {number} wait - Temps d'attente en ms
 * @returns {Function} Fonction débouncée
 */
function debounce(func, wait = 300) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Initialiser les tooltips Bootstrap
 */
function initTooltips() {
    if (typeof $().tooltip !== 'undefined') {
        $('[data-toggle="tooltip"]').tooltip();
    }
}

/**
 * Initialiser les popovers Bootstrap
 */
function initPopovers() {
    if (typeof $().popover !== 'undefined') {
        $('[data-toggle="popover"]').popover();
    }
}

// Initialisation automatique au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les tooltips et popovers
    initTooltips();
    initPopovers();
    
    // Ajouter un bouton scroll to top si la page est longue
    const scrollBtn = document.createElement('button');
    scrollBtn.id = 'scroll-to-top';
    scrollBtn.className = 'btn btn-primary rounded-circle';
    scrollBtn.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        display: none;
        z-index: 999;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    `;
    scrollBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    scrollBtn.onclick = scrollToTop;
    document.body.appendChild(scrollBtn);
    
    // Afficher/masquer le bouton selon le scroll
    window.addEventListener('scroll', debounce(function() {
        if (window.pageYOffset > 300) {
            scrollBtn.style.display = 'flex';
            scrollBtn.style.alignItems = 'center';
            scrollBtn.style.justifyContent = 'center';
        } else {
            scrollBtn.style.display = 'none';
        }
    }, 100));
    
    // Animer les éléments au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, observerOptions);
    
    // Observer tous les éléments avec la classe 'animate-on-scroll'
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });
});

// Exporter les fonctions pour une utilisation dans d'autres fichiers
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        copyToClipboard,
        formatNumber,
        formatCurrency,
        formatDate,
        confirmAction,
        showSuccess,
        showError,
        initDataTable,
        initSelect2,
        showLoader,
        hideLoader,
        scrollToTop,
        animateElement,
        calculatePercentageChange,
        debounce,
        initTooltips,
        initPopovers
    };
}
