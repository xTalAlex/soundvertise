<?php

namespace App\Models;

use App\Observers\PlaylistObserver;
use App\Traits\Blacklistable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;

#[ObservedBy([PlaylistObserver::class])]
class Playlist extends Model implements HasMedia
{
    use Blacklistable;
    use HasFactory;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('screenshot')
            ->acceptsFile(function (File $file) {
                return in_array($file->mimeType, ['image/jpeg', 'image/png', 'image/jpg']);
            })
            ->onlyKeepLatest(1);
    }

    /**
     * Scope a query to only include playlists that do not have bene accepted or refused.
     */
    public function scopePending(Builder $query): void
    {
        $query->where('approved', null)->where('reviewed_at', null);
    }

    /*
    |
    | Relationships
    |
    */

    /**
     * Get the user that owns the playlist.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the genre the playlist belongs to.
     */
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * Get the submissions for the playlsit.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Get current pairings for the song
     */
    public function pairings(): HasManyThrough
    {
        return $this->hasManyThrough(Pairing::class, Submission::class);
    }

    /**
     * Get current matches for the song
     */
    public function matches(): HasManyThrough
    {
        return $this->pairings()->where('pairings.is_match', true);
    }

    /**
     * Get the playlist spotify url if it is not defined.
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?? ('https://open.spotify.com/playlist/'.$this->spotify_id),
        );
    }

    /*
    |
    | Accessors & Mutators
    |
    */

    //
}
