<?php

namespace app\components\authManager;

use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class RbacAccessControl extends AccessControl
{
    /**
     * @param $action
     * @return bool
     * @throws ForbiddenHttpException
     */
    public function beforeAction($action): bool
    {
        $controllerName = $action->controller->id;
        $actionName = $action->id;

        $permission = sprintf('%s::%s', $controllerName, $actionName);

        if (Yii::$app->user->can($permission)) {
            throw new ForbiddenHttpException('Access denied');
        }

        return true;
    }
}