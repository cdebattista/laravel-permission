<?php

namespace Cdebattista\LaravelPermission\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class PermissionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The permission instance.
     *
     * @var \App\Permission
     */
    public $permission;

    /**
     * Create a new event instance.
     *
     * @param  \App\Permission  $permission
     * @return void
     */
    public function __construct($permission)
    {
        $this->permission = $permission;
    }
}