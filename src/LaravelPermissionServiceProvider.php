<?php

namespace Cdebattista\LaravelPermission;

use App\Actions\Permission\CreateGroup;
use App\Actions\Permission\CreatePermission;
use App\Actions\Permission\CreateUser;
use App\Actions\Permission\DeleteGroup;
use App\Actions\Permission\DeletePermission;
use App\Actions\Permission\DeleteUser;
use App\Actions\Permission\UpdateGroup;
use App\Actions\Permission\UpdatePermission;
use App\Actions\Permission\UpdateUser;
use Cdebattista\LaravelPermission\Http\Middleware\Permission;
use Illuminate\Contracts\Http\Kernel;
use Cdebattista\LaravelPermission\Http\Middleware\ShareInertiaData;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LaravelPermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/permission.php', 'permission');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePublishing();
        $this->configureRoutes();
        $this->configureCommands();
        $this->configurePermissionUSing();
        $this->configureGroupUSing();
        $this->configureUserUsing();
        $this->configurePolicies();

        if (config('permission.route.stack') === 'inertia') {
            $this->bootInertia();
        }
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/permission.php' => config_path('permission.php'),
        ], 'permission-config');

        $this->publishes([
            __DIR__.'/../database/migrations/2020_10_03_213840_permission.php' => database_path('migrations/2020_10_03_213840_permission.php'),
            __DIR__.'/../database/migrations/2020_10_04_164347_groups.php' => database_path('migrations/2020_10_04_164347_groups.php'),
            __DIR__.'/../database/migrations/2020_10_06_193628_group_permission.php' => database_path('migrations/2020_10_06_193628_group_permission.php'),
            __DIR__.'/../database/migrations/2020_10_08_192110_users_permissions.php' => database_path('migrations/2020_10_08_192110_users_permissions.php'),
            __DIR__.'/../database/migrations/2020_10_08_221049_users.php' => database_path('migrations/2020_10_08_221049_users.php'),
            __DIR__.'/../database/migrations/2020_10_09_115944_users_groups.php' => database_path('migrations/2020_10_09_115944_users_groups.php'),
        ], 'permission-migrations');

        $this->publishes([
            __DIR__.'/../routes/'.config('permission.route.stack').'.php' => base_path('routes/permission.php'),
        ], 'permission-routes');
    }

    /**
     * Configure the routes offered by the application.
     *
     * @return void
     */
    protected function configureRoutes()
    {
        Route::group(['namespace' => 'Cdebattista\LaravelPermission\Http\Controllers', 'domain' => config('permission.route.domain', null)], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/'.config('permission.route.stack').'.php');
        });
    }

    /**
     * Configure the commands offered by the application.
     *
     * @return void
     */
    protected function configureCommands()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Console\InstallCommand::class,
        ]);
    }

    /**
     * Configure permission using
     */
    public function configurePermissionUSing(){
        LaravelPermission::createPermissionUsing(CreatePermission::class);
        LaravelPermission::updatePermissionUsing(UpdatePermission::class);
        LaravelPermission::deletePermissionUsing(DeletePermission::class);
    }

    /**
     * Configure group using
     */
    public function configureGroupUSing(){
        LaravelPermission::createGroupUsing(CreateGroup::class);
        LaravelPermission::updateGroupUsing(UpdateGroup::class);
        LaravelPermission::deleteGroupUsing(DeleteGroup::class);
    }

    /**
     * Configure group using
     */
    public function configureUserUSing(){
        LaravelPermission::createUserUsing(CreateUser::class);
        LaravelPermission::updateUserUsing(UpdateUser::class);
        LaravelPermission::deleteUserUsing(DeleteUser::class);
    }

    public function configurePolicies(){
        LaravelPermissionPolicies::registerPolicies();
    }

    /**
     * Boot any Inertia related services.
     *
     * @return void
     */
    protected function bootInertia()
    {
        $kernel = $this->app->make(Kernel::class);

        $kernel->appendMiddlewareToGroup('web', ShareInertiaData::class);
        $kernel->appendToMiddlewarePriority(ShareInertiaData::class);

        $kernel->appendMiddlewareToGroup('web', Permission::class);
        $kernel->appendToMiddlewarePriority(Permission::class);
    }
}
