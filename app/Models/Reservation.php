<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reservations';

    protected $fillable = [
        'client_id',
        'bien_id',
        'date_debut',
        'date_fin',
        'nombre_personnes',
        'montant_total',
        'statut',
        'commentaires',
        'date_reservation',
        'date_confirmation',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'nombre_personnes' => 'integer',
        'montant_total' => 'decimal:2',
        'date_reservation' => 'datetime',
        'date_confirmation' => 'datetime',
    ];

    /**
     * Get the client for this reservation
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the property for this reservation
     */
    public function bien(): BelongsTo
    {
        return $this->belongsTo(Bien::class);
    }

    /**
     * Get the payment for this reservation
     */
    public function paiement(): HasOne
    {
        return $this->hasOne(Paiement::class);
    }

    /**
     * Confirm this reservation
     */
    public function confirmer(): bool
    {
        $updated = $this->update([
            'statut' => 'CONFIRME',
            'date_confirmation' => now(),
        ]);

        if ($updated && $this->bien) {
            $this->bien->update(['disponibilite' => 'loue']);
        }

        return $updated;
    }

    /**
     * Cancel this reservation
     */
    public function annuler(): bool
    {
        $updated = $this->update([
            'statut' => 'ANNULE',
        ]);

        if ($updated && $this->bien) {
            $this->bien->update(['disponibilite' => 'disponible']);
        }

        return $updated;
    }

    /**
     * Check if reservation is confirmed
     */
    public function estConfirmee(): bool
    {
        return $this->statut === 'CONFIRME';
    }

    /**
     * Check if reservation is pending
     */
    public function estEnAttente(): bool
    {
        return $this->statut === 'EN_ATTENTE';
    }

    /**
     * Get duration in days
     */
    public function getDureeEnJours(): int
    {
        return $this->date_debut->diffInDays($this->date_fin);
    }
}
