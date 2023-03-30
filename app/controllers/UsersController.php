<?php

namespace app\controllers;

use app\components\response\ValidationErrorException;
use app\models\forms\UserGetListForm;
use domain\scenarios\grandpay\user\getList\GetListUserResponse;
use domain\scenarios\grandpay\user\getList\GetListUserScenario;
use Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\di\NotInstantiableException;

class UsersController extends BaseRestController
{
    /**
     * @return array
     * @throws ValidationErrorException
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     * @throws Exception
     */
    public function actionIndex() :GetListUserResponse
    {
        $formModel = new UserGetListForm(Yii::$app->request->get());
        if ($formModel->validate() === false) {
            throw new ValidationErrorException($formModel->errors);
        }

        $scenario = Yii::$container->get(GetListUserScenario::class);
        return $scenario->execute($formModel->getRequest());
    }

}