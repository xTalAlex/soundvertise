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

    /**
     * Get the conclusion for the Report Model
     */
    public function conclusion(): HasOne
    {
        return $this->hasOne(ReportConclusion::class);
    }

    /**
     * Get the admin who managed the report for the Model (only available if there is a conclusion)
     */
    public function admin(): User
    {
        return $this->conclusion->admin;
    }

    /**
     * @param  array  $data  Includes optional 'conclusion' and
     *                       'action_taken' as a strings and 'meta' array of strings.
     *                       All inputs are optionals.
     */
    public function conclude($data, User $admin): ReportConclusion
    {
        $conclusion = (new ReportConclusion())->fill(array_merge($data, [
            'admin_id' => $admin->id,
        ]));

        $this->conclusion()->save($conclusion);

        return $conclusion;
    }
}
