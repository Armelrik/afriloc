<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'booking_id',
        'property_id',
        'sender_id',
        'receiver_id',
        'subject',
        'message',
        'attachments',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Get the booking related to this message
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the property related to this message
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the sender of this message
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the receiver of this message
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Scope to get unread messages
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope to get read messages
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope to get messages for a specific user
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('sender_id', $userId)
              ->orWhere('receiver_id', $userId);
        });
    }

    /**
     * Scope to get messages received by a user
     */
    public function scopeReceivedBy($query, int $userId)
    {
        return $query->where('receiver_id', $userId);
    }

    /**
     * Scope to get messages sent by a user
     */
    public function scopeSentBy($query, int $userId)
    {
        return $query->where('sender_id', $userId);
    }

    /**
     * Mark message as read
     */
    public function markAsRead(): bool
    {
        return $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Check if message is read
     */
    public function isRead(): bool
    {
        return $this->is_read;
    }

    /**
     * Check if user is the sender
     */
    public function isSender(int $userId): bool
    {
        return $this->sender_id === $userId;
    }

    /**
     * Check if user is the receiver
     */
    public function isReceiver(int $userId): bool
    {
        return $this->receiver_id === $userId;
    }

    /**
     * Get the other party in the conversation
     */
    public function getOtherParty(int $currentUserId): ?User
    {
        if ($this->sender_id === $currentUserId) {
            return $this->receiver;
        } elseif ($this->receiver_id === $currentUserId) {
            return $this->sender;
        }
        
        return null;
    }
}
