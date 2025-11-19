<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Renewal extends Model
{
    protected $fillable = [
        'booking_id',
        'user_id',
        'property_id',
        'current_end_date',
        'new_start_date',
        'new_end_date',
        'renewal_duration',
        'renewal_frequency',
        'renewal_amount',
        'status',
        'renewal_type',
        'notes',
        'requested_at',
        'approved_at',
        'rejected_at',
        'approved_by',
        'rejection_reason',
    ];

    protected $casts = [
        'current_end_date' => 'date',
        'new_start_date' => 'date',
        'new_end_date' => 'date',
        'renewal_amount' => 'decimal:2',
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    /**
     * Get the booking for this renewal
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the user who requested this renewal
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the property for this renewal
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the user who approved this renewal
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope to get pending renewals
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get approved renewals
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope to get rejected renewals
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope to get manual renewal requests
     */
    public function scopeManual($query)
    {
        return $query->where('renewal_type', 'manual');
    }

    /**
     * Scope to get automatic renewal requests
     */
    public function scopeAutomatic($query)
    {
        return $query->where('renewal_type', 'automatic');
    }

    /**
     * Approve this renewal
     */
    public function approve(int $approvedBy): bool
    {
        return $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $approvedBy,
        ]);
    }

    /**
     * Reject this renewal
     */
    public function reject(int $rejectedBy, string $reason = ''): bool
    {
        return $this->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'approved_by' => $rejectedBy, // Store who rejected it
            'rejection_reason' => $reason,
        ]);
    }

    /**
     * Cancel this renewal
     */
    public function cancel(): bool
    {
        return $this->update([
            'status' => 'cancelled',
        ]);
    }

    /**
     * Check if renewal is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if renewal is approved
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if renewal is rejected
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}
