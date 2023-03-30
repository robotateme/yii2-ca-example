<?php

namespace domain\scenarios\_base;

use domain\scenarios\admin\signOut\SignOutAdminResponse;

/**
 * Class BaseResponse
 * @package domain\scenarios\_base
 */
abstract class BaseResponse
{
    /** @var string */
    public const DATETIME_OUTPUT_FORMAT = 'Y-m-d H:i:s';
}