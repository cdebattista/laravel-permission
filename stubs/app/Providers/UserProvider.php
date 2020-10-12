<?php

namespace App\Providers;

use App\Actions\Jetstream\CreateUser;
use App\Actions\Jetstream\UpdateUser;
use App\Actions\Jetstream\DeleteUser;
use Cdebattista\LaravelPermission\LaravelPermission;
use Illuminate\Support\ServiceProvider;

class UserProvider extends ServiceProvider
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
        LaravelPermission::createUserUsing(CreateUser::class);
        LaravelPermission::updateUserUsing(UpdateUser::class);
        LaravelPermission::deleteUserUsing(DeleteUser::class);
    }
}