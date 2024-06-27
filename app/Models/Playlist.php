<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Playlist extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'spotify_user_id',
        'genre_id',
        'spotify_id',
        'url',
        'name',
        'description',
        'collaborative',
        'followers_total',
        'tracks_total',
        'approved',
        'rank',
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
            'collaborative' => 'boolean',
            'approved' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the playlist.
     *
     * It could be user_id or spotify_user_id.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'spotify_user_id', 'spotify_id');
    }

    /**
     * Get the genre the playlist belongs to.
     */
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
}
