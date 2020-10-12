<?php

namespace App\Actions\Permission;

use Cdebattista\LaravelPermission\Contracts\DeletesUser;


class DeleteUser implements DeletesUser
{
    /**
     * Delete user.
     *
     * @param  array  $user
     * @return mixed
     */
    public function delete($user)
    {
        $user->permissions()->detach();
        return $user->delete();
    }
}