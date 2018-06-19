<?php

namespace App\Policies;

use App\User;
use App\Datum;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Datum Policy
 */
class DatumPolicy
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
     * Determine whether the user can view the datum.
     *
     * @param  \App\User  $user
     * @param  \App\Datum  $datum
     * @return mixed
     */
    public function view(User $user, Datum $datum)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can create data.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can update the datum.
     *
     * @param  \App\User  $user
     * @param  \App\Datum  $datum
     * @return mixed
     */
    public function update(User $user, Datum $datum)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can delete the datum.
     *
     * @param  \App\User  $user
     * @param  \App\Datum  $datum
     * @return mixed
     */
    public function delete(User $user, Datum $datum)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }
}
