<?php

namespace Cdebattista\LaravelPermission\Contracts;

interface CreatesUser
{
    /**
     * Validate and create a new permission.
     *
     * @param  array  $input
     * @return mixed
     */
    public function create(array $input);
}