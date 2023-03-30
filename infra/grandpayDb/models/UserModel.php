<?php

namespace infra\grandpayDb\models;

use core\dictionaries\ErrorsDictionary;
use domain\entities\grandpay\user\dictionaries\UserGenderDictionary;
use yii\db\ActiveRecord;

/**
 * @property-read int $id
 * @property-read string $firstName
 * @property-read string $middleName
 * @property-read string $lastName
 * @property-read string $phone
 * @property-read string $email
 * @property-read string $referralCode
 * @property-read string $leaderReferralCode
 * @property-read string $city
 * @property-read string $countryCode
 * @property-read string $gender
 * @property-read string $birthdate
 * @property-read string $createTime
 * @property-read string $updateTime
 * @property-read bool $isBanned
 * @property-read int $levelId
 */
class UserModel extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'users';
    }

    public static function getDb()
    {
        return \Yii::$app->get('dbGrandPay');
    }
}