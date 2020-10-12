<?php
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['web']], function(){

    Route::group(['middleware' => config('permission.middleware.permission'), 'permissions' => ['administrator', 'create_permission', 'view_permission', 'edit_permission', 'delete_permission']], function (){
        Route::resource('permissions', Inertia\PermissionController::class)->except(['show']);
    });

    Route::group(['middleware' => config('permission.middleware.group'), 'permissions' => ['administrator', 'create_group', 'view_group', 'edit_group', 'delete_group']], function (){
        Route::resource('groups', Inertia\GroupController::class)->except(['show']);
    });

    Route::group(['middleware' => config('permission.middleware.user'), 'permissions' => ['administrator', 'create_user', 'view_user', 'edit_user', 'delete_user']], function (){
        Route::resource('users', Inertia\UserController::class)->except(['show']);
    });

});