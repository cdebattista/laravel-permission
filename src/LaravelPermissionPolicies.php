<?php

namespace Cdebattista\LaravelPermission;

use App\Models\Group;
use App\Models\Permission;
use App\Policies\GroupPolicy;
use App\Policies\PermissionPolicy;
use Illuminate\Support\Facades\Gate;

class LaravelPermissionPolicies
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected static  $policies = [
        Permission::class => PermissionPolicy::class,
        Group::class => GroupPolicy::class
    ];

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public static function registerPolicies()
    {
        foreach (self::policies() as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Get the policies defined on the provider.
     *
     * @return array
     */
    public static function policies()
    {
        return self::$policies;
    }
}
