<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceRequest extends Model
{
    protected $fillable = [
        'booking_id',
        'user_id',
        'property_id',
        'title',
        'description',
        'priority',
        'status',
        'category',
        'images',
        'response',
        'responded_at',
        'responded_by',
        'completed_at',
    ];

    protected $casts = [
        'images' => 'array',
        'responded_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the booking for this maintenance request
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the user who created this maintenance request
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the property for this maintenance request
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the user who responded to this maintenance request
     */
    public function responder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    /**
     * Scope to get pending requests
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get in progress requests
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope to get completed requests
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope to get urgent requests
     */
    public function scopeUrgent($query)
    {
        return $query->where('priority', 'urgent');
    }

    /**
     * Scope to get high priority requests
     */
    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', ['high', 'urgent']);
    }

    /**
     * Scope to get maintenance requests by promoter
     */
    public function scopeByPromoter($query, $promoterId)
    {
        return $query->whereHas('property', function ($q) use ($promoterId) {
            $q->where('promoter_id', $promoterId);
        });
    }

    /**
     * Mark as in progress
     */
    public function markAsInProgress(int $respondedBy, string $response = ''): bool
    {
        return $this->update([
            'status' => 'in_progress',
            'response' => $response,
            'responded_at' => now(),
            'responded_by' => $respondedBy,
        ]);
    }

    /**
     * Mark as completed
     */
    public function markAsCompleted(int $completedBy, string $response = ''): bool
    {
        return $this->update([
            'status' => 'completed',
            'response' => $response ?: $this->response,
            'completed_at' => now(),
            'responded_by' => $completedBy,
        ]);
    }

    /**
     * Cancel the request
     */
    public function cancel(): bool
    {
        return $this->update([
            'status' => 'cancelled',
        ]);
    }

    /**
     * Check if request is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if request is in progress
     */
    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Check if request is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if request is urgent
     */
    public function isUrgent(): bool
    {
        return $this->priority === 'urgent';
    }
}
