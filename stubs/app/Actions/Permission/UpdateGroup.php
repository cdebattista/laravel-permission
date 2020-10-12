<?php

namespace App\Actions\Permission;

use Cdebattista\LaravelPermission\Contracts\UpdatesGroup;
use Illuminate\Support\Facades\Validator;


class UpdateGroup implements UpdatesGroup
{
    /**
     * Validate and update permission.
     *
     * @param  array  $input
     * @param mixed $group
     * @return mixed
     */
    public function update($group, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'unique:groups,name,' . $group->id, 'max:64'],
            'group' => ['nullable', 'string', 'max:64'],
            'group_permissions' => ['nullable', 'array'],
            'group_permissions.*.id' => ['nullable', 'integer', 'exists:App\Models\Permission,id'],
        ])->validateWithBag('updateGroup');

        $group->permissions()->sync(collect($input['group_permissions'])->pluck('id'));

        return $group->update([
            'name' => $input['name'],
            'group' => $input['group'],
        ]);
    }
}