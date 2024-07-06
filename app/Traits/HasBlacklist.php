<?php

namespace App\Traits;

use App\Models\BlacklistItem;
use App\Models\Playlist;
use App\Models\Song;

trait HasBlacklist
{
    use Blacklistable;

    /**
     * Get all the blacklist items created by this user.
     */
    public function blacklistItems()
    {
        return $this->hasMany(BlacklistItem::class);
    }

    /**
     * Get all the entities of a given class that this user has blacklisted.
     */
    public function blacklistedEntities($class)
    {
        return $this->morphedByMany($class, 'blacklistable', 'blacklist_items', 'user_id', 'blacklistable_id')
            ->withTimestamps();
    }

    /**
     * Check if the given instance is blacklisted by the current user.
     *
     * @param  \Illuminate\Database\Eloquent\Model|null  $instance
     * @return bool
     */
    public function isInstanceBlacklisted($instance)
    {
        return $instance && $this->blacklistedEntities(get_class($instance))
            ->where('blacklistable_id', $instance->id)
            ->exists();
    }

    /**
     * Get all the users that this user has blacklisted.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function blacklistedUsers()
    {
        return $this->blacklistedEntities(\App\Models\User::class);
    }

    /**
     * Get all the playlists that this user has blacklisted.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function blacklistedPlaylists()
    {
        return $this->blacklistedEntities(Playlist::class);
    }

    /**
     * Get all the songs that this user has blacklisted.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function blacklistedSongs()
    {
        return $this->blacklistedEntities(Song::class);
    }
}
