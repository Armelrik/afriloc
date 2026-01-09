<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nom',
        'prenom',
        'email',
        'telephone',
        'password',
        'type_utilisateur',
        'date_inscription',
        'est_actif',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_inscription' => 'date',
            'est_actif' => 'boolean',
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the client profile for this user
     */
    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }

    /**
     * Get the promoter profile for this user
     */
    public function promoteur(): HasOne
    {
        return $this->hasOne(Promoteur::class);
    }

    /**
     * Get all reservations for this user (as client)
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

    /**
     * Get all payments for this user
     */
    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    /**
     * Get all notifications for this user
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'utilisateur_id');
    }

    /**
     * Get unread notifications for this user
     */
    public function notificationsNonLues(): HasMany
    {
        return $this->notifications()->where('est_lue', false);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->type_utilisateur === 'administrateur' || $this->hasRole('admin');
    }

    /**
     * Check if user is promoter
     */
    public function isPromoter(): bool
    {
        return $this->type_utilisateur === 'promoteur' || $this->hasRole('promoter');
    }

    /**
     * Check if user is client
     */
    public function isClient(): bool
    {
        return $this->type_utilisateur === 'client' || $this->hasRole('client');
    }

    /**
     * Get full name attribute
     */
    public function getNomCompletAttribute(): string
    {
        return trim(($this->prenom ?? '') . ' ' . ($this->nom ?? '')) ?: $this->name;
    }
}
