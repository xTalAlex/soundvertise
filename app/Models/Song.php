<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Song extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'genre_id',
        'spotify_id',
        'url',
        'name',
        'artist_id',
        'artist_name',
        'artist_genres',
        'duration_ms',
        'popularity',
        'acousticness',
        'speechiness',
        'danceability',
        'instrumentalness',
        'energy',
        'valence',
        'liveness',
        'loudness',
        'mode',
        'key',
        'tempo',
        'time_signature',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
        ];
    }

    /**
     * Get the user that owns the song.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the genre the song belongs to.
     */
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * Get the submissions for the song.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Get the song spotify url if it is not defined.
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?? ('https://open.spotify.com/track/'.$this->spotify_id),
        );
    }
}
