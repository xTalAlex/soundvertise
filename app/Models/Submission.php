<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Submission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'song_id',
        'playlist_id',
        'song_popularity_before',
        'song_popularity_after',
        'min_monthly_listeners',
    ];

    /**
     * Scope a query to only include not expired submissions.
     */
    public function scopeActive(Builder $query): void
    {
        // if now is friday,saturday or sunday, get this friday
        // if now is monday,tuesday, wednesday or thursday, get last friday
        $daysOffset = now() >= now()->startOfWeek()->addDays(4) ? 4 : -3;
        $query->where('created_at', '>=', now()->startOfWeek()->addDays($daysOffset));
    }

    /**
     * Get the user the submission belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the song the submission belongs to.
     */
    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class);
    }

    /**
     * Get the playlsit the submission belongs to.
     */
    public function playlist(): BelongsTo
    {
        return $this->belongsTo(Playlist::class);
    }

    /**
     * The pairings that belong to the submission.
     */
    public function pairings(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'pairings', 'paired_submission_id', 'submission_id')
            ->withPivot('id', 'is_match', 'accepted', 'reviewed_at', 'submission_song_added_at', 'submission_song_removed_at')
            ->withTimestamps();
    }

    /**
     * The pairings that belong to the submission.
     */
    public function relatedPairings(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'pairings', 'submission_id', 'paired_submission_id')
            ->withPivot('id', 'is_match', 'accepted', 'reviewed_at', 'submission_song_added_at', 'submission_song_removed_at')
            ->withTimestamps();
    }

    /**
     * Get pairings that have been accepted by both sides.
     */
    public function matches(): BelongsToMany
    {
        return $this->pairings()
            ->wherePivot('is_match', 1);
    }

    public function isExpired(): bool
    {
        // submission was created before monday 00:00?
        $daysOffset = ($this->created_at >= $this->created_at->startOfWeek()->addDays(4)) ? 11 : 4;

        return $this->created_at->startOfWeek()->addDays($daysOffset) <= now();
    }
}
