<?php

namespace infra\common;

use domain\scenarios\_interfaces\PasswordGeneratorInterface;
use Yii;
use yii\base\Exception;

class PasswordGenerator implements PasswordGeneratorInterface
{
    /**
     * @param string $password
     * @return string
     * @throws Exception
     */
    public function generateHash(string $password): string
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @param string $password
     * @param string $hash
     * @return bool|mixed
     */
    public function verify(string $password, string $hash)
    {
        return Yii::$app->security->validatePassword($password, $hash);
    }

    /**
     * @param int $length
     * @return string
     * @throws Exception
     */
    public function generateRandomString(int $length = 32): string
    {
        return Yii::$app->security->generateRandomString($length);
    }
}