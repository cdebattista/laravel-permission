<?php
namespace Cdebattista\LaravelPermission;

use Cdebattista\LaravelPermission\Contracts\CreatesGroup;
use Cdebattista\LaravelPermission\Contracts\CreatesPermission;
use Cdebattista\LaravelPermission\Contracts\CreatesUser;
use Cdebattista\LaravelPermission\Contracts\DeletesGroup;
use Cdebattista\LaravelPermission\Contracts\DeletesPermission;
use Cdebattista\LaravelPermission\Contracts\DeletesUser;
use Cdebattista\LaravelPermission\Contracts\UpdatesGroup;
use Cdebattista\LaravelPermission\Contracts\UpdatesPermission;
use Cdebattista\LaravelPermission\Contracts\UpdatesUser;

class LaravelPermission
{
    /**
     * Register a class / callback that should be used to create permission.
     *
     * @param  string  $class
     * @return void
     */
    public static function createPermissionUsing(string $class)
    {
        return app()->singleton(CreatesPermission::class, $class);
    }

    /**
     * Register a class / callback that should be used to update permission.
     *
     * @param  string  $class
     * @return void
     */
    public static function updatePermissionUsing(string $class)
    {
        return app()->singleton(UpdatesPermission::class, $class);
    }

    /**
     * Register a class / callback that should be used to update permission.
     *
     * @param  string  $class
     * @return void
     */
    public static function deletePermissionUsing(string $class)
    {
        return app()->singleton(DeletesPermission::class, $class);
    }

    /**
     * Register a class / callback that should be used to create group.
     *
     * @param  string  $class
     * @return void
     */
    public static function createGroupUsing(string $class)
    {
        return app()->singleton(CreatesGroup::class, $class);
    }

    /**
     * Register a class / callback that should be used to update group.
     *
     * @param  string  $class
     * @return void
     */
    public static function updateGroupUsing(string $class)
    {
        return app()->singleton(UpdatesGroup::class, $class);
    }

    /**
     * Register a class / callback that should be used to update permission.
     *
     * @param  string  $class
     * @return void
     */
    public static function deleteGroupUsing(string $class)
    {
        return app()->singleton(DeletesGroup::class, $class);
    }

    /**
     * Register a class / callback that should be used to create group.
     *
     * @param  string  $class
     * @return void
     */
    public static function createUserUsing(string $class)
    {
        return app()->singleton(CreatesUser::class, $class);
    }

    /**
     * Register a class / callback that should be used to update group.
     *
     * @param  string  $class
     * @return void
     */
    public static function updateUserUsing(string $class)
    {
        return app()->singleton(UpdatesUser::class, $class);
    }

    /**
     * Register a class / callback that should be used to update permission.
     *
     * @param  string  $class
     * @return void
     */
    public static function deleteUserUsing(string $class)
    {
        return app()->singleton(DeletesUser::class, $class);
    }
}