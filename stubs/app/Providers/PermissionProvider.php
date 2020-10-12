<?php

namespace App\Providers;

use App\Actions\Jetstream\CreatePermission;
use App\Actions\Jetstream\UpdatePermission;
use App\Actions\Jetstream\DeletePermission;
use Cdebattista\LaravelPermission\LaravelPermission;
use Illuminate\Support\ServiceProvider;

class PermissionProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        LaravelPermission::createPermissionUsing(CreatePermission::class);
        LaravelPermission::updatePermissionUsing(UpdatePermission::class);
        LaravelPermission::deletePermissionUsing(DeletePermission::class);
    }
}