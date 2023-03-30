<?php

namespace app\lib\mappings;

use domain\entities\admin\dictionaries\AdminValidationErrorsDictionary as D;
use Yii;

/**
 * Class AdminErrorsMapping
 */
class AdminErrorsMapping extends BaseErrorMapping
{
    /**
     * @return array
     */
    public static function getCustomErrors(): array
    {
        return [
            D::EMAIL_NOT_VALID => Yii::t('app', 'Значение «E-mail» не является правильным email адресом.'),
            D::ROLE_NOT_FOUND => Yii::t('app', 'Значение «Роль» не является правильным.')
        ];
    }

}