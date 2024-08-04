<?php

namespace App\Observers;

use App\Models\Playlist;
use Carbon\Carbon;

class PlaylistObserver
{
    /**
     * Handle the Playlist "created" event.
     */
    public function created(Playlist $playlist): void
    {
        //
    }

    /**
     * Handle the Playlist "updated" event.
     */
    public function updated(Playlist $playlist): void
    {
        if ($playlist->approved !== $playlist->getOriginal('approved')) {
            if ($playlist->approved === null) {
                $playlist->reviewed_at = null;
            } else {
                $playlist->reviewed_at = Carbon::now();
            }
            $playlist->saveQuietly();
        }

        // if($playlist->approved) email notification approved
        // else email notification refused
    }

    /**
     * Handle the Playlist "deleted" event.
     */
    public function deleted(Playlist $playlist): void
    {
        //
    }

    /**
     * Handle the Playlist "restored" event.
     */
    public function restored(Playlist $playlist): void
    {
        //
    }

    /**
     * Handle the Playlist "force deleted" event.
     */
    public function forceDeleted(Playlist $playlist): void
    {
        //
    }
}
