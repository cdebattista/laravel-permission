<?php

namespace App\Actions\Permission;

use Cdebattista\LaravelPermission\Contracts\DeletesPermission;


class DeletePermission implements DeletesPermission
{
    /**
     * Delete permission.
     *
     * @param  array  $permission
     * @return mixed
     */
    public function delete($permission)
    {
        return $permission->delete();
    }
}