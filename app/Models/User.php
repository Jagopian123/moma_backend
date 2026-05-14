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

    const AI_FREE_DAILY_LIMIT = 5;

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
        'ai_credits_today',
        'ai_credits_date',
        'last_purchase_token',
    ];

    protected $hidden = [
        'google_token',
        'google_refresh_token',
        'remember_token',
        'last_purchase_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'  => 'datetime',
            'premium_expires_at' => 'datetime',
            'is_premium'         => 'boolean',
            'ai_credits_date'    => 'date',
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

    public function remainingAiCredits(): int
    {
        if ($this->isPremium()) return -1; // -1 = unlimited

        $today = now()->toDateString();

        if ($this->ai_credits_date === null || $this->ai_credits_date->toDateString() !== $today) {
            return self::AI_FREE_DAILY_LIMIT;
        }

        return max(0, self::AI_FREE_DAILY_LIMIT - $this->ai_credits_today);
    }

    public function canUseAi(): bool
    {
        return $this->isPremium() || $this->remainingAiCredits() > 0;
    }

    public function incrementAiCredits(): void
    {
        $today = now()->toDateString();

        if ($this->ai_credits_date === null || $this->ai_credits_date->toDateString() !== $today) {
            $this->update([
                'ai_credits_today' => 1,
                'ai_credits_date'  => $today,
            ]);
        } else {
            $this->increment('ai_credits_today');
        }

        $this->refresh();
    }
}
