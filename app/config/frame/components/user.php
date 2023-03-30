<?php

use app\models\Identity;

return [
    'identityClass' => Identity::class,
    'authTimeout' => 3600,
    'enableAutoLogin' => false,
    'enableSession' => false,
    'loginUrl' => ['auth/sign-in'],
];