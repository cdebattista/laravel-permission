<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class GroupPermission extends Model
{
    protected $table = 'groups_permissions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_id',
        'permission_id'
    ];

}