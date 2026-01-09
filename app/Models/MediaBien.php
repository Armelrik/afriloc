<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaBien extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'media_biens';

    protected $fillable = [
        'bien_id',
        'type_media',
        'url_media',
        'description',
        'ordre',
        'date_ajout',
    ];

    protected $casts = [
        'ordre' => 'integer',
        'date_ajout' => 'date',
    ];

    /**
     * Get the property that owns this media
     */
    public function bien(): BelongsTo
    {
        return $this->belongsTo(Bien::class);
    }

    /**
     * Scope to get images
     */
    public function scopeImages($query)
    {
        return $query->where('type_media', 'IMAGE');
    }

    /**
     * Scope to get videos
     */
    public function scopeVideos($query)
    {
        return $query->where('type_media', 'VIDEO');
    }

    /**
     * Scope to order by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre');
    }
}
