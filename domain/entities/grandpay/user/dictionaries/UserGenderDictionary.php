<?php

namespace domain\entities\grandpay\user\dictionaries;

class UserGenderDictionary
{
    /** @var string */
    public const GENDER_MALE = 'male';

    /** @var string */
    public const GENDER_FEMALE = 'female';

    /**
     * @return int[]
     */
    public static function getAll(): array
    {
        return [self::GENDER_MALE, self::GENDER_FEMALE];
    }
}