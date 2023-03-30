<?php

use yii\rest\UrlRule;
use yii\web\UrlManager;

return [
    'class' => UrlManager::class,
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'hostInfo' => 'http://localhost/',
    'rules' => [
        [
            'class' => UrlRule::class,
            'pluralize' => false,
            'prefix' => 'api/v1/grandpay',
            'controller' => ['users'],
            'extraPatterns' => [
                'GET' => 'index',
            ],
        ],
        [
            'class' => UrlRule::class,
            'pluralize' => false,
            'prefix' => 'api/v1/swagger',
            'controller' => ['swagger'],
            'extraPatterns' => [
                'GET' => 'index',
            ],
        ],
        [
            'class' => UrlRule::class,
            'pluralize' => false,
            'prefix' => 'api/v1',
            'controller' => ['auth'],
            'extraPatterns' => [
                'OPTIONS' => 'options',
                'POST' => 'sign-in',
                'DELETE' => 'sign-out',
                'GET' => 'get-profile'
            ],
        ],
        [
            'class' => UrlRule::class,
            'pluralize' => false,
            'prefix' => 'api/v1',
            'tokens' => [
                '{id}' => '<id:\\w+>'
            ],
            'controller' => ['admin'],
            'extraPatterns' => [
                'PUT block/{id}' => 'block',
                'PUT unblock/{id}' => 'unblock',
                'POST' => 'create',
                'PUT,PATCH {id}' => 'update',
                'GET,HEAD {id}' => 'get-one',
                'GET,HEAD' => 'get-list',
            ],
        ],
    ],
];