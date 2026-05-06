<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'avatar',
        'google_id',
        'google_token',
        'google_refresh_token',
        'currency',
        'locale',
        'is_premium',
        'premium_expires_at',
    ];

    protected $hidden = [
        'google_token',
        'google_refresh_token',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'  => 'datetime',
            'premium_expires_at' => 'datetime',
            'is_premium'         => 'boolean',
        ];
    }

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }

    public function isPremium(): bool
    {
        if (!$this->is_premium) return false;
        if ($this->premium_expires_at === null) return true;
        return $this->premium_expires_at->isFuture();
    }
}