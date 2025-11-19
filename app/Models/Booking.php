<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'property_id',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'start_date',
        'end_date',
        'num_people',
        'rental_duration',
        'rental_frequency',
        'total_rent',
        'deposit_paid',
        'advance_paid',
        'platform_commission',
        'promoter_amount',
        'comments',
        'status',
        'payment_status',
        'payment_method',
        'payment_provider',
        'payment_reference',
        'payment_intent_id',
        'payment_completed_at',
        'transferred_to_promoter',
        'transfer_date',
        'total_amount',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'num_people' => 'integer',
        'rental_duration' => 'integer',
        'total_rent' => 'decimal:2',
        'deposit_paid' => 'decimal:2',
        'advance_paid' => 'decimal:2',
        'platform_commission' => 'decimal:2',
        'promoter_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'payment_completed_at' => 'datetime',
        'transferred_to_promoter' => 'boolean',
        'transfer_date' => 'date',
    ];

    /**
     * Get the property for this booking
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the user for this booking
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all payments for this booking
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get all renewal requests for this booking
     */
    public function renewals(): HasMany
    {
        return $this->hasMany(Renewal::class);
    }

    /**
     * Scope to get pending bookings
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get confirmed bookings
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope to get bookings by promoter
     */
    public function scopeByPromoter($query, $promoterId)
    {
        return $query->whereHas('property', function ($q) use ($promoterId) {
            $q->where('promoter_id', $promoterId);
        });
    }

    /**
     * Scope to get bookings pending approval
     */
    public function scopePendingApproval($query)
    {
        return $query->where('status', 'pending')
            ->where('payment_status', '!=', 'failed');
    }

    /**
     * Check if booking can be confirmed
     */
    public function canBeConfirmed(): bool
    {
        return $this->status === 'pending' && 
               in_array($this->payment_status, ['completed', 'partial']);
    }

    /**
     * Check if booking is active
     */
    public function isActive(): bool
    {
        return in_array($this->status, ['confirmed', 'active']) &&
               $this->end_date->isFuture();
    }

    /**
     * Get booking duration in days
     */
    public function getDurationInDays(): int
    {
        return $this->start_date->diffInDays($this->end_date);
    }
}
