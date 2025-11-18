<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    protected $fillable = [
        'title_fr',
        'title_en',
        'description_fr',
        'description_en',
        'type',
        'status',
        'price',
        'bedrooms',
        'bathrooms',
        'area',
        'location',
        'address',
        'latitude',
        'longitude',
        'images',
        'video_url',
        'featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'area' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'images' => 'array',
        'featured' => 'boolean',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
    ];

    /**
     * Get all bookings for this property
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Scope to get featured properties
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope to get available properties
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope to filter by type
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get the main image
     */
    public function getMainImageAttribute(): ?string
    {
        $images = $this->images ?? [];
        return count($images) > 0 ? $images[0] : null;
    }
}
