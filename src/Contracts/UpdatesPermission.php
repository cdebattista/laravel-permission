<?php

namespace Cdebattista\LaravelPermission\Contracts;

interface UpdatesPermission
{
    /**
     * Validate and update permission.
     *
     * @param mixed $permission
     * @param  array  $input
     * @return mixed
     */
    public function update($permission, array $input);
}