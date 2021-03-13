<?php

namespace App\Policies;

use App\Models\Bullet;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BulletPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bullet  $bullet
     * @return mixed
     */
    public function view(User $user, Bullet $bullet)
    {
        if ($bullet->user_id === $user->id) {
            return true;
        }

        if ($bullet->collection_id === null) {
            return false;
        }

        if ($user->belongsToTeam($bullet->collection->team)) {
            return true;
        }

        if ($bullet->collection->users()->where('id', $user->id)->exists()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bullet  $bullet
     * @return mixed
     */
    public function update(User $user, Bullet $bullet)
    {
        return $this->view($user, $bullet);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bullet  $bullet
     * @return mixed
     */
    public function delete(User $user, Bullet $bullet)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bullet  $bullet
     * @return mixed
     */
    public function restore(User $user, Bullet $bullet)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bullet  $bullet
     * @return mixed
     */
    public function forceDelete(User $user, Bullet $bullet)
    {
        //
    }
}
