<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notifications';

    protected $fillable = [
        'utilisateur_id',
        'type',
        'canal',
        'contenu',
        'priorite',
        'date_envoi',
        'est_lue',
        'date_lecture',
    ];

    protected $casts = [
        'date_envoi' => 'datetime',
        'est_lue' => 'boolean',
        'date_lecture' => 'datetime',
    ];

    /**
     * Get the user for this notification
     */
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    /**
     * Send SMS notification
     */
    public function envoyerSMS(): bool
    {
        // Logic to send SMS
        $this->update(['canal' => 'SMS', 'date_envoi' => now()]);
        return true;
    }

    /**
     * Send email notification
     */
    public function envoyerEmail(): bool
    {
        // Logic to send email
        $this->update(['canal' => 'EMAIL', 'date_envoi' => now()]);
        return true;
    }

    /**
     * Mark as read
     */
    public function marquerCommeLue(): bool
    {
        return $this->update([
            'est_lue' => true,
            'date_lecture' => now(),
        ]);
    }

    /**
     * Scope to get unread notifications
     */
    public function scopeNonLues($query)
    {
        return $query->where('est_lue', false);
    }

    /**
     * Scope to get read notifications
     */
    public function scopeLues($query)
    {
        return $query->where('est_lue', true);
    }

    /**
     * Scope to filter by type
     */
    public function scopeParType($query, string $type)
    {
        return $query->where('type', $type);
    }
}
