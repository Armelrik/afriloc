<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaiementCarte extends Model
{
    use HasFactory;

    protected $table = 'paiements_carte';

    protected $fillable = [
        'paiement_id',
        'numero_carte_masque',
        'type_carte',
        'token_paiement',
    ];

    /**
     * Get the payment for this card payment
     */
    public function paiement(): BelongsTo
    {
        return $this->belongsTo(Paiement::class);
    }

    /**
     * Authorize payment
     */
    public function authoriserPaiement(): bool
    {
        // Logic to authorize card payment
        return true;
    }

    /**
     * Capture payment
     */
    public function capturerPaiement(): bool
    {
        // Logic to capture card payment
        return true;
    }
}
