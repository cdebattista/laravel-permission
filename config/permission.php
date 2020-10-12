<?php
return [

    'middleware' =>[
        'permission' => ['auth', 'verified'],
        'group' => ['auth', 'verified'],
        'user' => ['auth', 'verified']
    ],

    'route' => [
        'domain' => null,
        'stack' => 'inertia'
    ],

];