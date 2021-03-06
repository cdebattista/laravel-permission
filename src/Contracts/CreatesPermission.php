<?php

namespace Cdebattista\LaravelPermission\Contracts;

interface CreatesPermission
{
    /**
     * Validate and create a new permission.
     *
     * @param  array  $input
     * @return mixed
     */
    public function create(array $input);
}