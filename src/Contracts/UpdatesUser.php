<?php

namespace Cdebattista\LaravelPermission\Contracts;

interface UpdatesUser
{
    /**
     * Validate and update user.
     *
     * @param mixed $user
     * @param  array  $input
     * @return mixed
     */
    public function update($user, array $input);
}