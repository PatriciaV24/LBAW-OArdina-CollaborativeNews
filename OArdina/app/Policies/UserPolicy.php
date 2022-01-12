<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $me
     * @return mixed
     */
    public function viewAny(User $me)
    {
        return !($me->is_banned || $me->is_deleted);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $me
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $me, User $user)
    {
        return !($me->is_banned || $me->is_deleted);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $me
     * @return mixed
     */
    public function create(User $me)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $me
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $me, User $user)
    {
        return ($me->id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $me
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $me, User $user)
    {
        return ($me->id === $user->id);
    }
}