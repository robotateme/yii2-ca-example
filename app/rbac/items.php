<?php

return [
    0 => [
        'type' => 1,
        'ruleName' => 'common',
        'children' => [
            'auth::sign-in',
        ],
    ],
    1 => [
        'type' => 1,
        'ruleName' => 'common',
        'children' => [
            'auth::sign-out',
            'admin::get-one',
        ],
    ],
    2 => [
        'type' => 1,
        'ruleName' => 'common',
        'children' => [
            'users::index',
            'auth::sign-out',
            'admin::block',
            'admin::create',
            'admin::delete',
            'admin::unblock',
            'admin::update',
            'admin::get-one',
            'admin::get-list',
        ],
    ],
    'users::index' => [
        'type' => 2,
    ],
    'auth::sign-in' => [
        'type' => 2,
    ],
    'auth::sign-out' => [
        'type' => 2,
    ],
    'admin::block' => [
        'type' => 2,
    ],
    'admin::create' => [
        'type' => 2,
    ],
    'admin::delete' => [
        'type' => 2,
    ],
    'admin::unblock' => [
        'type' => 2,
    ],
    'admin::update' => [
        'type' => 2,
    ],
    'admin::get-one' => [
        'type' => 2,
    ],
    'admin::get-list' => [
        'type' => 2,
    ],
];
