<?php

namespace App\Policies;

use App\User;
use App\DeviceLog;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * DeviceLog Policy
 */
class DeviceLogPolicy
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
     * Determine whether the user can view the deviceLog.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceLog  $deviceLog
     * @return mixed
     */
    public function view(User $user, DeviceLog $deviceLog)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can create deviceLogs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can update the deviceLog.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceLog  $deviceLog
     * @return mixed
     */
    public function update(User $user, DeviceLog $deviceLog)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can delete the deviceLog.
     *
     * @param  \App\User  $user
     * @param  \App\DeviceLog  $deviceLog
     * @return mixed
     */
    public function delete(User $user, DeviceLog $deviceLog)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }
}
