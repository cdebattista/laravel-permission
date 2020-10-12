<?php

namespace App\Actions\Permission;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Cdebattista\LaravelPermission\Contracts\CreatesUser;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;
use Laravel\Jetstream\Jetstream;


class CreateUser implements CreatesUser
{
    use PasswordValidationRules;

    /**
     * Validate and create a new user.
     *
     * @param  array  $input
     * @return mixed
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'lastname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'user_permissions' => ['nullable', 'array'],
            'user_permissions.*.id' => ['nullable', 'integer', 'exists:App\Models\Permission,id'],
            'user_groups' => ['nullable', 'array'],
            'user_groups.*.id' => ['nullable', 'integer', 'exists:App\Models\Group,id'],
            'password' => $this->passwordRules(),
        ])->validateWithBag('createUser');

        $user =  User::create([
            'lastname' => $input['lastname'],
            'firstname' => $input['firstname'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->permissions()->sync(collect($input['user_permissions'])->pluck('id'));
        $user->groups()->sync(collect($input['user_groups'])->pluck('id'));

        if(Jetstream::hasTeamFeatures()){
            $user->ownedTeams()->save(\App\Models\Team::forceCreate([
                'user_id' => $user->id,
                'name' => explode(' ', $user->lastname, 2)[0]."'s Team",
                'personal_team' => true,
            ]));
        }

        return $user;
    }
}