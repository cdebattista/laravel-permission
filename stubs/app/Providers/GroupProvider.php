<?php

namespace App\Providers;

use App\Actions\Jetstream\CreateGroup;
use App\Actions\Jetstream\UpdateGroup;
use App\Actions\Jetstream\DeleteGroup;
use Cdebattista\LaravelPermission\LaravelPermission;
use Illuminate\Support\ServiceProvider;

class GroupProvider extends ServiceProvider
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
        LaravelPermission::createGroupUsing(CreateGroup::class);
        LaravelPermission::updateGroupUsing(UpdateGroup::class);
        LaravelPermission::deleteGroupUsing(DeleteGroup::class);
    }
}