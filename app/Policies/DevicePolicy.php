<?php

namespace App\Policies;

use App\User;
use App\Device;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Device Policy
 */
class DevicePolicy
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
     * Determine whether the user can view the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function view(User $user, Device $device)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can create devices.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can update the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function update(User $user, Device $device)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can delete the device.
     *
     * @param  \App\User  $user
     * @param  \App\Device  $device
     * @return mixed
     */
    public function delete(User $user, Device $device)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }
}
