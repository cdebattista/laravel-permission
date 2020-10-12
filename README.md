<p align="center"><img src="https://github.com/cdebattista/laravel-permission-js/raw/master/logo.svg"></p>

<p align="center">
    <a href="https://github.com/cdebattista/laravel-permission/actions">
        <img src="https://github.com/cdebattista/laravel-permission/workflows/tests/badge.svg" alt="Build Status">
    </a>
    <a href="https://packagist.org/packages/cdebattista/laravel-permission">
        <img src="https://img.shields.io/cdebattista/dt/laravel-permission" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/cdebattista/laravel-permission">
        <img src="https://img.shields.io/packagist/v/cdebattista/laravel-permission" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/cdebattista/laravel-permission">
        <img src="https://img.shields.io/packagist/l/cdebattista/laravel-permission" alt="License">
    </a>
</p>

<img src="https://github.com/cdebattista/laravel-permission/raw/master/.github/img/permissions.png">

:star: Star on GitHub — it helps!

## Table of content

- [Installation](#installation)
    - [Composer](#composer)
        - [Inertia](#inertia)
- [How it works](#howitworks)
    - [Inertia](#howInertia)
        - [PHP](#howInertiaPHP)
        - [Vuejs](#howInertiaVuejs)
- [License](#license)
- [Links](#links)

## Installation
### Composer

`composer require cdebattista/laravel-permission`

#### Inertia
For now, support only Jetstream with Inertia.

>In local installation and using `php artisan serve`, 
>change `APP_URL=http://127.0.0.1:8000` in .env. Otherwise, you will get an error:
>`Access to XMLHttpRequest at 'http://localhost/users' from origin 'http://127.0.0.1:8000`

`php artisan permission:install inertia`

`npm install && npm run dev`

`php artisan migrate`

## How it works

### Inertia

You can customize Actions, Models, Policies and Pages as your wishes.

#### PHP
In php code :

```php
$user->hasPermissions(['view_user', 'view_group', 'view_permission']);
```
[more details here](stubs/app/Policies/PermissionPolicy.php)

Protect your routes :

```php
Route::group(['permissions' => ['administrator', 'create_user', 'view_user', 'edit_user', 'delete_user']], function (){
    Route::resource('users', Inertia\UserController::class)->except(['show']);
});
```
[more details here](routes/inertia.php)

#### Vuejs
in VUE files :

```javascript
this.HasPermissions(['view_user', 'view_group', 'view_permission'])
```
[more details here](stubs/inertia/resources/js/Pages/Permission/Index.vue)

You can use directive v-can :
```html
<div v-can="['view_user', 'view_group', 'view_permission']">...</div>
```
[more details here](stubs/inertia/resources/js/Pages/Permission/Edit.vue)

## License

Laravel Permission is open-sourced software licensed under the [MIT license](LICENSE.md).

## Links

* [Inertia JS Table for Vue](https://github.com/Harmonic/inertia-table-vue)
* [vue-multiselect](https://github.com/shentao/vue-multiselect)
