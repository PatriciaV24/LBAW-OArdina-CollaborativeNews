<?php

namespace App\Policies;

use Illuminate\Http\Request;
use App\Models\Requests;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestsPolicy
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
     * @param  \App\Models\Requests  $request
     * @return mixed
     */
    public function view(User $user, Requests $request)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Requests  $request
     * @return mixed
     */
    public function update(User $user, Requests $request)
    {
        return $user->is_admin && !($user->is_deleted || $user->is_banned);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Requests  $request
     * @return mixed
     */
    public function delete(User $user, Requests $request)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Requests  $request
     * @return mixed
     */
    public function restore(User $user, Requests $request)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Requests  $request
     * @return mixed
     */
    public function forceDelete(User $user, Requests $request)
    {
        //
    }
}
