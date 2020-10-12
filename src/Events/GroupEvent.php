<?php

namespace Cdebattista\LaravelPermission\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class GroupEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The group instance.
     *
     * @var \App\Group
     */
    public $group;

    /**
     * Create a new event instance.
     *
     * @param  \App\Group  $group
     * @return void
     */
    public function __construct($group)
    {
        $this->$group = $group;
    }
}