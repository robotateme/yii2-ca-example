<?php

namespace app\lib\mappings;

use core\dictionaries\ErrorsDictionary as D;
use yii\helpers\ArrayHelper;

/**
 * Class BaseErrorMapping
 * @package app\lib\mappings
 */
abstract class BaseErrorMapping extends BaseMapping
{
    /**
     * @return array
     */
    public static function getAll(): array
    {
        return ArrayHelper::merge([
            D::IS_NOT_UNIQUE => \Yii::t('app', 'Такое значение поля уже занято.'),
        ], static::getCustomErrors());
    }

    /**
     * @return array
     */
    abstract public static function getCustomErrors(): array;
}