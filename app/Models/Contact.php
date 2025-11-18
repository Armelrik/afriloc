<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
    ];

    /**
     * Scope to get recent contacts
     */
    public function scopeRecent($query, int $limit = 10)
    {
        return $query->latest()->limit($limit);
    }
}
