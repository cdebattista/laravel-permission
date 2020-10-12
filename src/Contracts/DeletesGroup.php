<?php

namespace Cdebattista\LaravelPermission\Contracts;

interface DeletesGroup
{
    /**
     * Delete permission.
     *
     * @param  array  $permission
     * @return mixed
     */
    public function delete($permission);
}