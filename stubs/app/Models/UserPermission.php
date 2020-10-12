<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UserPermission extends Model
{
    protected $table = 'users_permissions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'permission_id'
    ];
}