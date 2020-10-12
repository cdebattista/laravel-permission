<?php

namespace App\Actions\Permission;

use Illuminate\Support\Facades\Hash;
use Cdebattista\LaravelPermission\Contracts\UpdatesUser;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;


class UpdateUser implements UpdatesUser
{
    use PasswordValidationRules;
    /**
     * Validate and update user.
     *
     * @param  array  $input
     * @param mixed $user
     * @return mixed
     */
    public function update($user, array $input)
    {
        $validator = Validator::make($input, [
            'lastname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'user_permissions' => ['nullable', 'array'],
            'user_permissions.*.id' => ['nullable', 'integer', 'exists:App\Models\Permission,id'],
            'user_groups' => ['nullable', 'array'],
            'user_groups.*.id' => ['nullable', 'integer', 'exists:App\Models\Group,id'],
        ]);

        if($input['password']){
            $validator->addRules([
                'password' => $this->passwordRules(),
            ]);
        }

        $validator->validateWithBag('updateUser');

        $user->permissions()->sync(collect($input['user_permissions'])->pluck('id'));
        $user->groups()->sync(collect($input['user_groups'])->pluck('id'));

        $user->update([
            'lastname' => $input['lastname'],
            'firstname' => $input['firstname'],
            'email' => $input['email'],
        ]);

        if($input['password']){
            $user->update([
                'password' => Hash::make($input['password']),
            ]);
        }

        return $user;
    }
}