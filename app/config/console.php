<?php

use core\helpers\Configurator;

$cfg = new Configurator(['configPath' => __DIR__]);

$config = [
    'id' => 'console-app',
    'language' => 'ru-RU',
    'controllerNamespace' => 'app\commands',
    'basePath' => dirname(__DIR__),
    'vendorPath' => __DIR__ . '../../vendor',
    'aliases' => $cfg->requireConfig('aliases.php'),
    'version' => $cfg->requireConfig('version.php'),
    'bootstrap' => $cfg->requireConfig('bootstrapConsole.php'),
    'container' => $cfg->requireConfig('containerConsole.php'),
    'components' => $cfg->requireConfig('componentsConsole.php'),
    'modules' => $cfg->requireConfig('modulesConsole.php'),

    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => [
                '@infra/db/migrations',
            ],
        ],
    ],
];

return $config;