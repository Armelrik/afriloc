<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promoter extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'phone',
        'whatsapp',
        'address',
        'identification_number',
        'identification_document',
        'bank_account',
        'commission_rate',
        'status',
        'verified_at',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function approve()
    {
        $this->update([
            'status' => 'approved',
            'verified_at' => now(),
        ]);
    }
}
