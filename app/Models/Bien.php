<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bien extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'biens';

    protected $fillable = [
        'promoteur_id',
        'titre',
        'description',
        'type_bien',
        'adresse',
        'ville',
        'quartier',
        'superficie',
        'nombre_pieces',
        'nombre_chambres',
        'nombre_salles_bain',
        'prix_location',
        'frequence_location',
        'depot_garantie',
        'avance',
        'disponibilite',
        'statut',
        'est_publie',
        'date_ajout',
        'date_publication',
    ];

    protected $casts = [
        'superficie' => 'decimal:2',
        'prix_location' => 'decimal:2',
        'depot_garantie' => 'decimal:2',
        'avance' => 'decimal:2',
        'nombre_pieces' => 'integer',
        'nombre_chambres' => 'integer',
        'nombre_salles_bain' => 'integer',
        'est_publie' => 'boolean',
        'date_ajout' => 'date',
        'date_publication' => 'datetime',
    ];

    /**
     * Get the promoter that owns this property
     */
    public function promoteur(): BelongsTo
    {
        return $this->belongsTo(Promoteur::class);
    }

    /**
     * Get all media for this property
     */
    public function medias(): HasMany
    {
        return $this->hasMany(MediaBien::class);
    }

    /**
     * Get all reservations for this property
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get images for this property
     */
    public function images(): HasMany
    {
        return $this->medias()->where('type_media', 'IMAGE');
    }

    /**
     * Get videos for this property
     */
    public function videos(): HasMany
    {
        return $this->medias()->where('type_media', 'VIDEO');
    }

    /**
     * Scope to get published properties
     */
    public function scopePublie($query)
    {
        return $query->where('est_publie', true)->where('statut', 'publie');
    }

    /**
     * Scope to get available properties
     */
    public function scopeDisponible($query)
    {
        return $query->where('disponibilite', 'disponible');
    }

    /**
     * Scope to filter by type
     */
    public function scopeParType($query, string $type)
    {
        return $query->where('type_bien', $type);
    }

    /**
     * Scope to filter by city
     */
    public function scopeParVille($query, string $ville)
    {
        return $query->where('ville', $ville);
    }

    /**
     * Publish this property
     */
    public function publier(): bool
    {
        return $this->update([
            'est_publie' => true,
            'statut' => 'publie',
            'date_publication' => now(),
        ]);
    }

    /**
     * Unpublish this property
     */
    public function depublier(): bool
    {
        return $this->update([
            'est_publie' => false,
            'statut' => 'archive',
        ]);
    }

    /**
     * Check if property is published
     */
    public function estPublie(): bool
    {
        return $this->est_publie && $this->statut === 'publie';
    }

    /**
     * Check if property is available
     */
    public function estDisponible(): bool
    {
        return $this->disponibilite === 'disponible';
    }
}
