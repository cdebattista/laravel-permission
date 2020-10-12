<?php

namespace App\Actions\Permission;

use Cdebattista\LaravelPermission\Contracts\DeletesGroup;


class DeleteGroup implements DeletesGroup
{
    /**
     * Delete permission.
     *
     * @param  array  $group
     * @return mixed
     */
    public function delete($group)
    {
        $group->permissions()->detach();
        return $group->delete();
    }
}