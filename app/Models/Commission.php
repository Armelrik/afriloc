<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commission extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'commissions';

    protected $fillable = [
        'paiement_id',
        'promoteur_id',
        'pourcentage_plateforme',
        'montant_commission',
        'montant_promoteur',
        'date_calcul',
        'est_transfere',
        'date_transfert',
    ];

    protected $casts = [
        'pourcentage_plateforme' => 'decimal:2',
        'montant_commission' => 'decimal:2',
        'montant_promoteur' => 'decimal:2',
        'date_calcul' => 'date',
        'est_transfere' => 'boolean',
        'date_transfert' => 'datetime',
    ];

    /**
     * Get the payment for this commission
     */
    public function paiement(): BelongsTo
    {
        return $this->belongsTo(Paiement::class);
    }

    /**
     * Get the promoter for this commission
     */
    public function promoteur(): BelongsTo
    {
        return $this->belongsTo(Promoteur::class);
    }

    /**
     * Calculate commission
     */
    public static function calculer(Paiement $paiement, float $pourcentagePlateforme = 10.0): self
    {
        $montantTotal = $paiement->montant;
        $montantCommission = ($montantTotal * $pourcentagePlateforme) / 100;
        $montantPromoteur = $montantTotal - $montantCommission;

        $bien = $paiement->reservation->bien;
        $promoteurId = $bien->promoteur_id;

        return self::create([
            'paiement_id' => $paiement->id,
            'promoteur_id' => $promoteurId,
            'pourcentage_plateforme' => $pourcentagePlateforme,
            'montant_commission' => $montantCommission,
            'montant_promoteur' => $montantPromoteur,
            'date_calcul' => now(),
        ]);
    }

    /**
     * Transfer to promoter
     */
    public function transfererPromoteur(): bool
    {
        return $this->update([
            'est_transfere' => true,
            'date_transfert' => now(),
        ]);
    }

    /**
     * Generate report
     */
    public function genererRapport(): array
    {
        return [
            'paiement_id' => $this->paiement_id,
            'promoteur' => $this->promoteur->raison_sociale,
            'montant_total' => $this->paiement->montant,
            'commission_plateforme' => $this->montant_commission,
            'montant_promoteur' => $this->montant_promoteur,
            'date_calcul' => $this->date_calcul,
            'est_transfere' => $this->est_transfere,
        ];
    }
}
