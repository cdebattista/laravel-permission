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
     * @param  \App\Models\User  $authUser
     * @return mixed
     */
    public function viewAny(User $authUser)
    {
        return $authUser->hasPermissions(['administrator', 'view_user', 'create_user', 'edit_user', 'delete_user']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $authUser
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $authUser, User $user)
    {
        return $authUser->hasPermissions(['administrator', 'view_user']);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $authUser
     * @return mixed
     */
    public function create(User $authUser)
    {
        return $authUser->hasPermissions(['administrator', 'create_user']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $authUser
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $authUser, User $user)
    {
        return $authUser->hasPermissions(['administrator', 'edit_user']);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $authUser
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $authUser, User $user)
    {
        return $authUser->hasPermissions(['administrator', 'delete_user']);
    }
}
