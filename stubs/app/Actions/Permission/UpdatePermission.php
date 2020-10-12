<?php

namespace App\Actions\Permission;

use Cdebattista\LaravelPermission\Contracts\UpdatesPermission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UpdatePermission implements UpdatesPermission
{
    /**
     * Validate and update permission.
     *
     * @param  array  $input
     * @param mixed $permission
     * @return mixed
     */
    public function update($permission, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:64'],
            'group' => ['nullable', 'string', 'max:64'],
            'slug' => ['required', 'unique:permissions,slug,' . $permission->id, 'string', 'max:64'],
        ])->validateWithBag('updatePermission');

        return $permission->update([
            'name' => $input['name'],
            'group' => $input['group'],
            'slug' => Str::snake($input['slug']),
        ]);
    }
}