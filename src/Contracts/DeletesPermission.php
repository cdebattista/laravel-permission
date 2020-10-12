<?php

namespace Cdebattista\LaravelPermission\Contracts;

interface DeletesPermission
{
    /**
     * Delete permission.
     *
     * @param  array  $permission
     * @return mixed
     */
    public function delete($permission);
}