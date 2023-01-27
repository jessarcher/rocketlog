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
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user): mixed
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Collection  $collection
     * @return mixed
     */
    public function view(User $user, Collection $collection): mixed
    {
        if ($collection->user_id === $user->id) {
            return true;
        }

        if ($collection->users()->where('id', $user->id)->exists()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user): mixed
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Collection  $collection
     * @return mixed
     */
    public function update(User $user, Collection $collection): mixed
    {
        return $this->view($user, $collection);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Collection  $collection
     * @return mixed
     */
    public function delete(User $user, Collection $collection): mixed
    {
        if ($collection->user_id === $user->id) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Collection  $collection
     * @return mixed
     */
    public function restore(User $user, Collection $collection): mixed
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Collection  $collection
     * @return mixed
     */
    public function forceDelete(User $user, Collection $collection): mixed
    {
        //
    }

    /**
     * Determine whether the user can share the collection
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Collection  $collection
     * @return mixed
     */
    public function share(User $user, Collection $collection): mixed
    {
        if ($collection->user_id === $user->id) {
            return true;
        }
    }
}
