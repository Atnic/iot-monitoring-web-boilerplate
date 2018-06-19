<?php

namespace App\Policies;

use App\User;
use App\Parameter;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Parameter Policy
 */
class ParameterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view list of model.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can view the parameter.
     *
     * @param  \App\User  $user
     * @param  \App\Parameter  $parameter
     * @return mixed
     */
    public function view(User $user, Parameter $parameter)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can create parameters.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can update the parameter.
     *
     * @param  \App\User  $user
     * @param  \App\Parameter  $parameter
     * @return mixed
     */
    public function update(User $user, Parameter $parameter)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can delete the parameter.
     *
     * @param  \App\User  $user
     * @param  \App\Parameter  $parameter
     * @return mixed
     */
    public function delete(User $user, Parameter $parameter)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }
}
