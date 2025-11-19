<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    protected $fillable = [
        'promoter_id',
        'title_fr',
        'title_en',
        'description_fr',
        'description_en',
        'type',
        'status',
        'price',
        'rental_frequency',
        'monthly_rent',
        'deposit_amount',
        'advance_payment',
        'commission_amount',
        'commission_rate',
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
        'is_for_rent',
        'is_for_sale',
        'availability_status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'monthly_rent' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'advance_payment' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'area' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'images' => 'array',
        'featured' => 'boolean',
        'is_for_rent' => 'boolean',
        'is_for_sale' => 'boolean',
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

    public function promoter(): BelongsTo
    {
        return $this->belongsTo(Promoter::class);
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

    /**
     * Scope to filter by promoter
     */
    public function scopeByPromoter($query, int $promoterId)
    {
        return $query->where('promoter_id', $promoterId);
    }

    /**
     * Scope to get available properties for rent
     */
    public function scopeAvailableForRent($query)
    {
        return $query->where('is_for_rent', true)
                    ->where('availability_status', 'available');
    }

    /**
     * Scope to get available properties for sale
     */
    public function scopeAvailableForSale($query)
    {
        return $query->where('is_for_sale', true)
                    ->where('availability_status', 'available');
    }

    /**
     * Calculate commission for this property
     */
    public function calculateCommission(): float
    {
        $commissionRate = $this->commission_rate ?? config('locafri.commission.default_rate', 10);
        return round($this->price * ($commissionRate / 100), 2);
    }
}
