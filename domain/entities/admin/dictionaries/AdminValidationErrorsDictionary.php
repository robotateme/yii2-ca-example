<?php

namespace domain\entities\admin\dictionaries;

use core\dictionaries\ErrorsDictionary;

/**
 * Class AdminValidationErrorsDictionary
 * @package domain\entities\admin\dictionaries
 */
class AdminValidationErrorsDictionary extends ErrorsDictionary
{
    /** @var string */
    public const EMAIL_NOT_VALID = 'email-not-valid';

    /** @var string */
    public const ROLE_NOT_FOUND = 'role-not-found';
}