<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'adresse',
        'ville_residence',
    ];

    protected $casts = [
        //
    ];

    /**
     * Get the user that owns the client profile
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all reservations for this client (through user)
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'client_id', 'user_id');
    }
}
