<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBackup extends Model
{
    protected $fillable = ['user_id', 'data', 'backed_up_at', 'is_compressed'];

    protected $casts = [
        'backed_up_at'  => 'datetime',
        'is_compressed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
