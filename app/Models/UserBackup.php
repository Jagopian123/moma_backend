<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBackup extends Model
{
    protected $fillable = ['user_id', 'data', 'backed_up_at'];

    protected $casts = [
        'backed_up_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
