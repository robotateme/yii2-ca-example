<?php

return [
    'class' => yii\web\DbSession::class,
    'writeCallback' => function ($session) {
        return [
            'id_user' => Yii::$app->user->id,
        ];
    },
];