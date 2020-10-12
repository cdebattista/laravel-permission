<?php
namespace App\Models;

use Cdebattista\LaravelPermission\Traits\Filter;
use Cdebattista\LaravelPermission\Events\PermissionCreated;
use Cdebattista\LaravelPermission\Events\PermissionUpdated;
use Cdebattista\LaravelPermission\Events\PermissionDeleted;
use Cdebattista\LaravelPermission\Traits\Order;
use Illuminate\Database\Eloquent\Model;


class Permission extends Model
{
    use Filter, Order;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'group',
        'slug',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => PermissionCreated::class,
        'updated' => PermissionUpdated::class,
        'deleted' => PermissionDeleted::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups(){
        return $this->belongsToMany(Group::class, 'groups_permissions');
    }

    /**
     * @return array
     */
    public function optGroup(){
        $data = [];
        $i = 0;
        $permissions = $this->all()->groupBy('group');
        foreach($permissions as $key => $value){
            $data[$i]['group'] = $key;
            foreach($value as $permission){
                $data[$i]['options'][] = ['id' => $permission->id, 'name' => $permission->name];
            }
            $i++;
        }
        return $data;
    }
}