<?php

namespace App\Actions\Permission;

use App\Models\Group;
use Cdebattista\LaravelPermission\Contracts\CreatesGroup;
use Illuminate\Support\Facades\Validator;


class CreateGroup implements CreatesGroup
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
            'name' => ['required', 'string','unique:groups', 'max:64'],
            'group' => ['nullable', 'string', 'max:64'],
            'group_permissions' => ['nullable', 'array'],
            'group_permissions.*.id' => ['nullable', 'integer', 'exists:App\Models\Permission,id'],
        ])->validateWithBag('createGroup');

        $group =  Group::create([
            'name' => $input['name'],
            'group' => $input['group'],
        ]);

        $group->permissions()->sync(collect($input['group_permissions'])->pluck('id'));

        return $group;
    }
}