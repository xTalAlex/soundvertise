<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Report extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who managed the report for the Model (only available if there is a conclusion)
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @param  array  $data  Includes optional 'conclusion' and
     *                       'action_taken' as a strings and 'meta' array of strings.
     *                       All inputs are optionals.
     */
    public function conclude($data, User $admin): bool
    {
        $res = $this->update([
            'admin_id' => $admin->id,
            'conclusion' => $data['conclusion'] ?? null,
            'action_taken' => $data['action_taken'] ?? null,
            'meta' => $data['meta'] ?? $this->attributes['meta'],
        ]);

        return $res;
    }
}
