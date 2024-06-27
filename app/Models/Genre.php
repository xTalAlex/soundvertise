<?php

namespace App\Models;

use App\Observers\GenreObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy([GenreObserver::class])]
class Genre extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'spotify_name',
        'primary_color',
        'secondary_color',
        'order',
        'position_x',
        'position_y',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['icon'];

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
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['media'];

    protected function icon(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->hasMedia() ? $this->getFirstMediaUrl() : null,
        );
    }

    /**
     * Get the playlists for the genre.
     */
    public function playlists(): HasMany
    {
        return $this->hasMany(Playlist::class);
    }

    /**
     * Get the songs for the genre.
     */
    public function songs(): HasMany
    {
        return $this->hasMany(Song::class);
    }
}
