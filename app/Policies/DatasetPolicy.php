<?php

namespace App\Policies;

use App\User;
use App\Dataset;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Dataset Policy
 */
class DatasetPolicy
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
     * Determine whether the user can view the dataset.
     *
     * @param  \App\User  $user
     * @param  \App\Dataset  $dataset
     * @return mixed
     */
    public function view(User $user, Dataset $dataset)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can create datasets.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can update the dataset.
     *
     * @param  \App\User  $user
     * @param  \App\Dataset  $dataset
     * @return mixed
     */
    public function update(User $user, Dataset $dataset)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }

    /**
     * Determine whether the user can delete the dataset.
     *
     * @param  \App\User  $user
     * @param  \App\Dataset  $dataset
     * @return mixed
     */
    public function delete(User $user, Dataset $dataset)
    {
        return true; // TODO: Change as needed, but leave it true if no policy
    }
}
