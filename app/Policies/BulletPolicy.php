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
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Bullet $bullet): bool
    {
        if ($bullet->user_id === $user->id) {
            return true;
        }

        if ($bullet->collection_id === null) {
            return false;
        }

        if ($bullet->collection->user_id === $user->id) {
            return true;
        }

        if ($bullet->collection->users()->where('id', $user->id)->exists()) {
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
    public function update(User $user, Bullet $bullet): bool
    {
        return $this->view($user, $bullet);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Bullet $bullet): bool
    {
        return $this->view($user, $bullet);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Bullet $bullet): bool
    {
        return $this->delete($user, $bullet);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Bullet $bullet): bool
    {
        return $this->delete($user, $bullet);
    }
}
