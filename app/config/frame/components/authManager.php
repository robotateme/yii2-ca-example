<?php

use domain\entities\admin\dictionaries\AdminRolesDictionary;
use yii\rbac\PhpManager;

return [
    'class' => PhpManager::class,
    'defaultRoles' => [AdminRolesDictionary::ADMIN, AdminRolesDictionary::SUPER_ADMIN],
];