<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    public function conclusion(): HasOne
    {
        return $this->hasOne(ReportConclusion::class);
    }

    public function admin(): User
    {
        return $this->conclusion->admin;
    }

    public function conclude($data, User $admin): ReportConclusion
    {
        $conclusion = (new ReportConclusion())->fill(array_merge($data, [
            'admin_id' => $admin->id,
        ]));

        $this->conclusion()->save($conclusion);

        return $conclusion;
    }
}
