<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaiementMobileMoney extends Model
{
    use HasFactory;

    protected $table = 'paiements_mobile_money';

    protected $fillable = [
        'paiement_id',
        'operateur',
        'numero_telephone',
        'code_transaction',
    ];

    /**
     * Get the payment for this mobile money payment
     */
    public function paiement(): BelongsTo
    {
        return $this->belongsTo(Paiement::class);
    }

    /**
     * Initiate payment
     */
    public function initierPaiement(): bool
    {
        // Logic to initiate mobile money payment
        return true;
    }

    /**
     * Confirm payment
     */
    public function confirmerPaiement(): bool
    {
        // Logic to confirm mobile money payment
        return true;
    }
}
