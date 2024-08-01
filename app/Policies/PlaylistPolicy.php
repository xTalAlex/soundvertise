<?php

namespace App\Policies;

use App\Models\Playlist;
use App\Models\User;

class PlaylistPolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Playlist $playlist): bool
    {
        return $user->id == $playlist->user_id && $playlist->reviewed_at == null;
    }
}
