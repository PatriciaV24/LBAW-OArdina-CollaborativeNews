<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ReportUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportUserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ReportUser $report
     *
     * @return mixed
     */
    public function view(?User $user, ReportUser $report)
    {
        
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ReportUser $report
     *
     * @return mixed
     */
    public function update(User $user, ReportUser $report)
    {
        
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\ReportUser $report
     *
     * @return mixed
     */
    public function delete(User $user, ReportUser $report)
    {
        
    }
}