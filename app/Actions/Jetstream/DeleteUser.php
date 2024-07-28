<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    public function delete(User $user): void
    {
        //$user->submission()->delete();
        //$user->pairings(); // set as null user
        //$user->matches(); // rimuovi canzoni da playlist degli altri
        //$user->songs()->delete(); // set null user_id
        $user->playlists()->delete();

        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();
    }
}
