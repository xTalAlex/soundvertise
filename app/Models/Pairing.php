<?php

namespace App\Models;

use App\Traits\Reportable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Pairing extends Pivot
{
    use HasFactory;
    use Reportable;

    protected $table = 'pairings';

    /*
    |
    | song_added_at e song_removed_at refer to submission_id song
    | and are set by paired_submissiom_id operations
    |
    */

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'submission_id',
        'paired_submission_id',
        'is_match',
        'accepted',
        'answered_at',
        'submission_song_added_at',
        'submission_song_removed_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_match' => 'boolean',
            'accepted' => 'boolean',
            'answered_at' => 'datetime',
            'submission_song_added_at' => 'datetime',
            'submission_song_removed_at' => 'datetime',
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'laravel_through_key',
    ];

    /**
     * Scope a query to only include not expired submissions.
     */
    public function scopeActive(Builder $query): void
    {
        $query->whereHas('submission', fn ($query) => $query->active());
    }

    /**
     * Scope a query to only include matches with song not removed from the pairedSubmission playlist
     */
    public function scopeOngoingMatches(Builder $query): void
    {
        $query->where('is_match', true)
            ->whereNull('submission_song_removed_at')
            ->where('submission_song_added_at', '<=', now()->subDays(30));
    }

    /**
     * Get the first submission the pairing belongs to.
     */
    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    /**
     * Get the second submission the pairing belongs to.
     */
    public function pairedSubmission(): BelongsTo
    {
        return $this->belongsTo(Submission::class, 'paired_submission_id', 'id');
    }
}
