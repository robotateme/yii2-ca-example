<?php

use yii\db\Connection;

return [
    'class' => Connection::class,
    'dsn' => 'pgsql:host=postgres;port=5432;dbname=backend_admin',
    'username' => 'backend',
    'password' => 'secret',
];
