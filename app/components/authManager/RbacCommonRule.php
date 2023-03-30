<?php

namespace app\components\authManager;

use Yii;
use yii\rbac\Rule;

class RbacCommonRule extends Rule
{
    /** @var string */
    public $name = 'common';

    /**
     * @param $user
     * @param $item
     * @param $params
     * @return bool
     */
    public function execute($user, $item, $params): bool
    {
        if(Yii::$app->user->isGuest === false) {
            $role = (int)Yii::$app->user->identity->role;

            return (int)$item->name === $role;
        }

        if ((int)$item->name === RbacRolesDictionary::GUEST) {
            return true;
        }

        return false;
    }
}