<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoriqueValidation extends Model
{
    use HasFactory;

    protected $table = 'historique_validations';

    protected $fillable = [
        'promoteur_id',
        'effectue_par_id',
        'action',
        'date_action',
        'details',
        'ancien_statut',
        'nouveau_statut',
    ];

    protected $casts = [
        'date_action' => 'datetime',
    ];

    /**
     * Get the promoter for this history entry
     */
    public function promoteur(): BelongsTo
    {
        return $this->belongsTo(Promoteur::class);
    }

    /**
     * Get the user who performed this action
     */
    public function effectuePar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'effectue_par_id');
    }

    /**
     * Create a history entry
     */
    public static function creer(
        int $promoteurId,
        int $adminId,
        string $action,
        ?string $ancienStatut = null,
        ?string $nouveauStatut = null,
        ?string $details = null
    ): self {
        return self::create([
            'promoteur_id' => $promoteurId,
            'effectue_par_id' => $adminId,
            'action' => $action,
            'date_action' => now(),
            'ancien_statut' => $ancienStatut,
            'nouveau_statut' => $nouveauStatut,
            'details' => $details,
        ]);
    }
}
