<?php

namespace App\Observers;

use App\Models\Genre;
use Illuminate\Support\Str;

class GenreObserver
{
    /**
     * Handle the Genre "creating" event.
     */
    public function creating(Genre $genre): void
    {
        if (! $genre->slug) {
            $genre->slug = Str::slug($genre->name);
        }
    }

    /**
     * Handle the Genre "created" event.
     */
    public function created(Genre $genre): void
    {
        $genre->order = $genre->id;
        $genre->saveQuietly();
    }

    /**
     * Handle the Genre "updating" event.
     */
    public function updating(Genre $genre): void
    {
        if (! $genre->slug) {
            $genre->slug = Str::slug($genre->name);
        }
        if (! $genre->order) {
            $genre->order = $genre->id;
        }
    }

    /**
     * Handle the Genre "updated" event.
     */
    public function updated(Genre $genre): void
    {
        //
    }

    /**
     * Handle the Genre "deleted" event.
     */
    public function deleted(Genre $genre): void
    {
        //
    }

    /**
     * Handle the Genre "restored" event.
     */
    public function restored(Genre $genre): void
    {
        //
    }

    /**
     * Handle the Genre "force deleted" event.
     */
    public function forceDeleted(Genre $genre): void
    {
        //
    }
}
