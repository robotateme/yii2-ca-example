<?php


use app\components\authManager\RbacRolesDictionary;

$guest = RbacRolesDictionary::GUEST;
$admin = RbacRolesDictionary::ADMIN;
$super = RbacRolesDictionary::SUPER_ADMIN;

return [
    'roles' => [$guest, $admin, $super],

    'permissions' => [
        'auth' => [
            'sign-in' => [$guest],
            'sign-out' => [$super, $admin],
            'get-profile' => [$super, $admin],
        ],
        'admin' => [
            'block' => [$super],
            'create' => [$super],
            'delete' => [$super],
            'unblock' => [$super],
            'update' => [$super],
            'get-one' => [$super],
            'get-list' => [$super],
        ]
    ]
];