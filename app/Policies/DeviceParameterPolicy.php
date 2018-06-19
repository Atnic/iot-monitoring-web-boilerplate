<?php

namespace App\Policies;

use App\User;
use App\DeviceParameter;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * DeviceParameter Policy
 */
class DeviceParameterPolicy
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
     * Determine whether the user can view the deviceParameter.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceParameter  $deviceParameter
     * @return mixed
     */
    public function view(User $user, DeviceParameter $deviceParameter)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can create deviceParameters.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can update the deviceParameter.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceParameter  $deviceParameter
     * @return mixed
     */
    public function update(User $user, DeviceParameter $deviceParameter)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can delete the deviceParameter.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceParameter  $deviceParameter
     * @return mixed
     */
    public function delete(User $user, DeviceParameter $deviceParameter)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }
}
