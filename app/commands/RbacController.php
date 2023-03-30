<?php

namespace app\commands;

use app\components\authManager\RbacGenerator;
use yii\base\Exception;
use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * @return void
     * @throws Exception
     */
    public function actionInit()
    {
        $generator = new RbacGenerator();
        $generator->init();
    }
}