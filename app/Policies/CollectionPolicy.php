<?php

namespace App\Policies;

use App\Models\Collection;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CollectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Collection $collection): bool
    {
        if ($collection->user_id === $user->id) {
            return true;
        }

        if ($collection->users()->where('id', $user->id)->exists()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Collection $collection): bool
    {
        return $this->view($user, $collection);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Collection $collection): bool
    {
        if ($collection->user_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Collection $collection): bool
    {
        return $this->delete($user, $collection);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Collection $collection): bool
    {
        return $this->delete($user, $collection);
    }

    /**
     * Determine whether the user can share the collection
     */
    public function share(User $user, Collection $collection): bool
    {
        if ($collection->user_id === $user->id) {
            return true;
        }

        return false;
    }
}
