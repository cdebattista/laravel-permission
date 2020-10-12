<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Cdebattista\LaravelPermission\Traits\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Cdebattista\LaravelPermission\Traits\Filter;
use Cdebattista\LaravelPermission\Traits\Order;

class User extends Authenticatable{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Filter;
    use Order;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lastname',
        'firstname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(){
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups(){
        return $this->belongsToMany(Group::class, 'users_groups');
    }

    /**
     * @return array
     */
    public function optGroupPermissions(){
        return $this->permissions->map(function($item){
            return ['id' => $item->id, 'name' => $item->name];
        });
    }

    /**
     * @return array
     */
    public function optGroupGroups(){
        return $this->groups->map(function($item){
            return ['id' => $item->id, 'name' => $item->name];
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getPermissions(){
        $data = collect();
        $this->groups->map(function($item){
            return $item->permissions->pluck('slug');
        })->push($this->permissions->pluck('slug'))->transform(function($iterations) use ($data){
            foreach($iterations as $iteration){
                $data->push($iteration);
            }
        });
        $data = $data->unique()->values();
        return $data;
    }

    /**
     * @param $permissions
     *
     * @return bool
     */
    public function hasPermissions($permissions){
        if(!is_array($permissions)){
            $permissions = [$permissions];
        }
        $currentPermissions = $this->getPermissions();
        return $currentPermissions->intersect($permissions)->isEmpty() ? false : true;
    }
}
