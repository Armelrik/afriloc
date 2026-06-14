<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
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

    public function getPublicUrlAttribute(): string
    {
        $url = ltrim((string) $this->url_media, '/');

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        if ($url !== '' && file_exists(public_path($url))) {
            return asset($url);
        }

        if ($url !== '' && file_exists(storage_path('app/public/'.$url))) {
            return Storage::url($url);
        }

        if (str_starts_with($url, 'images/biens/')) {
            $fallbacks = [
                'house1.jpg',
                'house2.jpg',
                'house3.jpg',
                'apartment1.jpg',
                'apartment2.jpg',
                'land1.jpg',
            ];

            $index = max(0, ((int) $this->bien_id + (int) $this->ordre - 2) % count($fallbacks));

            return asset('images/'.$fallbacks[$index]);
        }

        return Storage::url($url);
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
