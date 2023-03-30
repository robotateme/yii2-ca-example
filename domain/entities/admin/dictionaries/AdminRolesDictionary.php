<?php

namespace domain\entities\admin\dictionaries;

class AdminRolesDictionary
{
    /** @var int */
    public const ADMIN = 1;

    /** @var int */
    public const SUPER_ADMIN = 2;

    /**
     * @return int[]
     */
    public static function getAll(): array
    {
        return [self::ADMIN, self::SUPER_ADMIN];
    }
}