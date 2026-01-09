<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DemandeValidation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'demandes_validation';

    protected $fillable = [
        'promoteur_id',
        'statut',
        'date_demande',
        'date_traitement',
        'traite_par_admin_id',
        'commentaires',
        'motif_rejet',
        'score_completude',
    ];

    protected $casts = [
        'date_demande' => 'date',
        'date_traitement' => 'datetime',
        'score_completude' => 'integer',
    ];

    /**
     * Get the promoter for this validation request
     */
    public function promoteur(): BelongsTo
    {
        return $this->belongsTo(Promoteur::class);
    }

    /**
     * Get the admin who processed this request
     */
    public function traitePar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'traite_par_admin_id');
    }

    /**
     * Submit the validation request
     */
    public function soumettre(): bool
    {
        $this->update([
            'statut' => 'EN_ATTENTE',
            'date_demande' => now(),
            'score_completude' => $this->promoteur->calculerScoreCompletude(),
        ]);

        return true;
    }

    /**
     * Approve the validation request
     */
    public function approuver(int $adminId): bool
    {
        $this->update([
            'statut' => 'VALIDE',
            'date_traitement' => now(),
            'traite_par_admin_id' => $adminId,
        ]);

        $this->promoteur->approuver($adminId);

        return true;
    }

    /**
     * Reject the validation request
     */
    public function rejeter(int $adminId, string $motif): bool
    {
        $this->update([
            'statut' => 'REJETE',
            'date_traitement' => now(),
            'traite_par_admin_id' => $adminId,
            'motif_rejet' => $motif,
        ]);

        $this->promoteur->rejeter($adminId, $motif);

        return true;
    }

    /**
     * Request additional documents
     */
    public function demanderComplement(int $adminId, string $commentaires): bool
    {
        $this->update([
            'statut' => 'INCOMPLET',
            'date_traitement' => now(),
            'traite_par_admin_id' => $adminId,
            'commentaires' => $commentaires,
        ]);

        $this->promoteur->marquerIncomplet($adminId, $commentaires);

        return true;
    }

    /**
     * Calculate completeness score
     */
    public function calculerScore(): int
    {
        $score = $this->promoteur->calculerScoreCompletude();
        $this->update(['score_completude' => $score]);
        return $score;
    }
}
