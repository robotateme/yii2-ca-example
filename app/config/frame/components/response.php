<?php

use app\components\response\ApiResponse;
use app\components\response\ResponseHandler;
use yii\web\Response;

return [
    'class' => ApiResponse::class,
    'format' => Response::FORMAT_JSON,
    'on beforeSend' => [
        ResponseHandler::class,
        'handle',
    ],
];