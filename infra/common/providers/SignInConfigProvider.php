<?php

namespace infra\common\providers;

use domain\scenarios\admin\signIn\_interfaces\SignInConfigProviderInterface;

class SignInConfigProvider implements SignInConfigProviderInterface
{
    public function getTokenExpirationTime() : string
    {
        return \Yii::$app->params['access_token_expiration_time'];
    }
}