<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paiement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'paiements';

    protected $fillable = [
        'reservation_id',
        'montant',
        'methode_paiement',
        'statut',
        'date_paiement',
        'reference_transaction',
        'numero_recu',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_paiement' => 'datetime',
    ];

    /**
     * Get the reservation for this payment
     */
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * Get the mobile money payment details
     */
    public function paiementMobileMoney(): HasOne
    {
        return $this->hasOne(PaiementMobileMoney::class);
    }

    /**
     * Get the card payment details
     */
    public function paiementCarte(): HasOne
    {
        return $this->hasOne(PaiementCarte::class);
    }

    /**
     * Get the commission for this payment
     */
    public function commission(): HasOne
    {
        return $this->hasOne(Commission::class);
    }

    /**
     * Mark payment as completed
     */
    public function marquerValide(): bool
    {
        return $this->update([
            'statut' => 'VALIDE',
            'date_paiement' => now(),
        ]);
    }

    /**
     * Mark payment as failed
     */
    public function marquerEchoue(string $raison = null): bool
    {
        return $this->update([
            'statut' => 'ECHOUE',
        ]);
    }

    /**
     * Check if payment is completed
     */
    public function estValide(): bool
    {
        return $this->statut === 'VALIDE';
    }

    /**
     * Check if payment is pending
     */
    public function estEnAttente(): bool
    {
        return $this->statut === 'EN_ATTENTE';
    }

    /**
     * Generate receipt number
     */
    public function genererNumeroRecu(): string
    {
        $numero = 'REC-' . strtoupper(uniqid());
        $this->update(['numero_recu' => $numero]);
        return $numero;
    }
}
