<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Pairing extends Pivot
{
    use HasFactory;

    protected $table = 'pairings';

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
