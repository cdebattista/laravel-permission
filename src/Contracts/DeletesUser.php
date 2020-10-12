<?php

namespace Cdebattista\LaravelPermission\Contracts;

interface DeletesUser
{
    /**
     * Delete user.
     *
     * @param  array  $user
     * @return mixed
     */
    public function delete($user);
}