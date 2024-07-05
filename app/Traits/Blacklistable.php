<?php

namespace App\Traits;

use App\Models\User;

trait Blacklistable
{
    /**
     * Get all users who have blacklisted this model.
     */
    public function blacklistedBy()
    {
        return $this->morphToMany(User::class, 'blacklistable', 'blacklist_items', 'blacklistable_id', 'user_id');
    }

    /**
     * Check if the current user has blacklisted the owner of this model.
     *
     * @return bool
     */
    public function isCurrentUserBlacklistedByOwner()
    {
        $currentUser = auth()->user();

        return $currentUser && ($this instanceof User ?
                $this->isInstanceBlacklisted($currentUser) :
                $this->user?->isInstanceBlacklisted($currentUser)
        );
    }

    /**
     * Get the IDs of models blacklisted by the current user.
     *
     * @param  \Illuminate\Database\Eloquent\Model|null  $instance
     * @return \Closure
     */
    public function blacklistedModelIds($instance = null)
    {
        $instance = $instance ?: $this;

        return function ($query) use ($instance) {
            $query->select('blacklistable_id')
                ->from('blacklist_items')
                ->where('blacklistable_type', $instance->getMorphClass())
                ->where('user_id', User::currentUser()?->id);
        };
    }

    /**
     * Get the IDs of model owners who blacklisted the current user.
     *
     * @param  \Illuminate\Database\Eloquent\Model|null  $user
     * @return \Closure
     */
    public function blacklistedByOwnersIds($user = null)
    {
        $user = $user ?: auth()->user();

        return function ($query) use ($user) {
            $query->select('user_id')
                ->from('blackliste_items')
                ->where('blacklistable_type', $user?->getMorphClass())
                ->where('blacklistable_id', $user?->id);
        };
    }

    /**
     * Scope a query to exclude models blacklisted by the current user or created by users blacklisted by that user,
     * or created by users who have blacklisted the current user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisibleToCurrentUser($query)
    {
        $blacklistedModelIds = $this->blacklistedModelIds();
        $blacklistedUserIds = $this->blacklistedModelIds(auth()->user());

        return $query->whereNotIn('id', $blacklistedModelIds)
            ->whereNotIn('user_id', $blacklistedUserIds)
            ->whereNotIn('user_id', $this->blacklistedByOwnersIds());
    }

    /**
     * Check if the model is blacklisted by a specific user.
     *
     * @param  int  $userId
     * @return bool
     */
    public function isBlacklistedBy($userId)
    {
        return $this->blacklistedBy()->where('user_id', $userId)->exists();
    }

    /**
     * Determine if the model is currently blacklisted by any user.
     *
     * @return bool
     */
    public function isBlacklisted()
    {
        return $this->blacklistedBy()->exists();
    }

    /**
     * Get the count of users who have blacklisted this model.
     *
     * @return int
     */
    public function blacklistedByCount()
    {
        return $this->blacklistedBy()->count();
    }

    /**
     * Get the latest user who blacklisted this model.
     *
     * @return \App\Models\User|null
     */
    public function latestBlacklistedBy()
    {
        return $this->blacklistedBy()->latest()->first();
    }
}
