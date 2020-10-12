<?php
namespace App\Models;

use Cdebattista\LaravelPermission\Traits\Filter;
use Cdebattista\LaravelPermission\Events\GroupCreated;
use Cdebattista\LaravelPermission\Events\GroupUpdated;
use Cdebattista\LaravelPermission\Events\GroupDeleted;
use Cdebattista\LaravelPermission\Traits\Order;
use Illuminate\Database\Eloquent\Model;


class Group extends Model
{
    use Filter, Order;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'group'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => GroupCreated::class,
        'updated' => GroupUpdated::class,
        'deleted' => GroupDeleted::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(){
        return $this->belongsToMany(Permission::class, 'groups_permissions');
    }

    /**
     * @return array
     */
    public function optGroup(){
        $data = [];
        $i = 0;
        $groups = $this->all()->groupBy('group');
        foreach($groups as $key => $value){
            $data[$i]['group'] = $key;
            foreach($value as $group){
                $data[$i]['options'][] = ['id' => $group->id, 'name' => $group->name];
            }
            $i++;
        }
        return $data;
    }

    /**
     * @return array
     */
    public function optGroupPermissions(){
        return $this->permissions->map(function($item){
            return ['id' => $item->id, 'name' => $item->name];
        });
    }
}