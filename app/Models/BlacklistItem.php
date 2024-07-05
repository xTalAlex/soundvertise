<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class BlacklistItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blacklistable_id',
        'blacklistable_type',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function blacklistable(): MorphTo
    {
        return $this->morphTo();
    }
}
