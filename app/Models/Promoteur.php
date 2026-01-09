<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promoteur extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'promoteurs';

    protected $fillable = [
        'user_id',
        'raison_sociale',
        'type_structure',
        'numero_siret',
        'adresse_professionnelle',
        'ville',
        'description',
        'statut',
        'date_inscription',
        'date_validation',
        'valide_par',
        'motif_rejet',
        'commentaires_validation',
        'cnib_recto',
        'cnib_verso',
        'photo_promoteur',
        'justificatif_domicile',
        'registre_commerce',
        'attestation_fiscale',
        'certificat_propriete',
        'assurance_rc',
        'cnib_recto_verifie',
        'cnib_verso_verifie',
        'photo_verifiee',
        'justificatif_verifie',
        'registre_verifie',
        'attestation_verifiee',
    ];

    protected $casts = [
        'date_inscription' => 'date',
        'date_validation' => 'datetime',
        'cnib_recto_verifie' => 'boolean',
        'cnib_verso_verifie' => 'boolean',
        'photo_verifiee' => 'boolean',
        'justificatif_verifie' => 'boolean',
        'registre_verifie' => 'boolean',
        'attestation_verifiee' => 'boolean',
    ];

    /**
     * Get the user that owns the promoter profile
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who validated this promoter
     */
    public function validePar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'valide_par');
    }

    /**
     * Get the validation request for this promoter
     */
    public function demandeValidation(): HasOne
    {
        return $this->hasOne(DemandeValidation::class);
    }

    /**
     * Get all validation history for this promoter
     */
    public function historiqueValidations(): HasMany
    {
        return $this->hasMany(HistoriqueValidation::class);
    }

    /**
     * Get all properties for this promoter
     */
    public function biens(): HasMany
    {
        return $this->hasMany(Bien::class);
    }

    /**
     * Get all commissions for this promoter
     */
    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    /**
     * Scope to get approved promoters
     */
    public function scopeValide($query)
    {
        return $query->where('statut', 'VALIDE');
    }

    /**
     * Scope to get pending promoters
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'EN_ATTENTE');
    }

    /**
     * Scope to get rejected promoters
     */
    public function scopeRejete($query)
    {
        return $query->where('statut', 'REJETE');
    }

    /**
     * Scope to get incomplete promoters
     */
    public function scopeIncomplet($query)
    {
        return $query->where('statut', 'INCOMPLET');
    }

    /**
     * Check if promoter is validated
     */
    public function estValide(): bool
    {
        return $this->statut === 'VALIDE';
    }

    /**
     * Check if promoter can add properties
     */
    public function peutAjouterBien(): bool
    {
        return $this->estValide();
    }

    /**
     * Calculate completeness score
     */
    public function calculerScoreCompletude(): int
    {
        $documentsObligatoires = [
            'cnib_recto',
            'cnib_verso',
            'photo_promoteur',
            'justificatif_domicile',
            'registre_commerce',
            'attestation_fiscale'
        ];

        $documentsPresents = 0;
        foreach ($documentsObligatoires as $doc) {
            if (!empty($this->$doc)) {
                $documentsPresents++;
            }
        }

        return (int) (($documentsPresents / count($documentsObligatoires)) * 100);
    }

    /**
     * Check if all documents are verified
     */
    public function tousDocumentsVerifies(): bool
    {
        return $this->cnib_recto_verifie
            && $this->cnib_verso_verifie
            && $this->photo_verifiee
            && $this->justificatif_verifie
            && $this->registre_verifie
            && $this->attestation_verifiee;
    }

    /**
     * Approve this promoter
     */
    public function approuver(int $adminId): bool
    {
        $this->update([
            'statut' => 'VALIDE',
            'date_validation' => now(),
            'valide_par' => $adminId,
        ]);

        return true;
    }

    /**
     * Reject this promoter
     */
    public function rejeter(int $adminId, string $motif): bool
    {
        $this->update([
            'statut' => 'REJETE',
            'valide_par' => $adminId,
            'motif_rejet' => $motif,
        ]);

        return true;
    }

    /**
     * Mark as incomplete
     */
    public function marquerIncomplet(int $adminId, string $commentaires): bool
    {
        $this->update([
            'statut' => 'INCOMPLET',
            'valide_par' => $adminId,
            'commentaires_validation' => $commentaires,
        ]);

        return true;
    }
}

