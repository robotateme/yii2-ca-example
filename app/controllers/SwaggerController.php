<?php

namespace app\controllers;

use OpenApi\Generator;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;


class SwaggerController extends Controller
{
    public function actionIndex()
    {
        $openApi = Generator::scan([Yii::getAlias('@app'), Yii::getAlias('@domain/entities'), Yii::getAlias('@domain/scenarios/')], );
        echo $openApi->toJson();
        die;
    }
}