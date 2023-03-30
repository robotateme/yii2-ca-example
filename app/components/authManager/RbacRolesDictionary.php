<?php

namespace app\components\authManager;

use domain\entities\admin\dictionaries\AdminRolesDictionary;

class RbacRolesDictionary extends AdminRolesDictionary
{
    /** @var int */
    public const GUEST = 0;
}