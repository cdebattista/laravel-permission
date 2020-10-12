<?php

namespace App\Actions\Permission;

use App\Models\Permission;
use Cdebattista\LaravelPermission\Contracts\CreatesPermission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class CreatePermission implements CreatesPermission
{
    /**
     * Validate and create a new permission.
     *
     * @param  array  $input
     * @return mixed
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:64'],
            'group' => ['nullable', 'string', 'max:64'],
            'slug' => ['required', 'unique:permissions', 'string', 'max:64'],
        ])->validateWithBag('createPermission');

        return Permission::create([
            'name' => $input['name'],
            'group' => $input['group'],
            'slug' => Str::snake($input['slug']),
        ]);
    }
}