<?php

namespace domain\scenarios\admin\signOut;

use domain\entities\admin\exceptions\AdminNotValidException;
use domain\scenarios\_base\BaseResponse;

/**
 * Class SignOutAdminResponse
 * @package domain\scenarios\admin\signOut
 *
 * @OA\Schema(title="Sign Out Response", description="Sign-Out Admin Response Model")
 */
class SignOutAdminResponse extends BaseResponse
{
    /**
     * @return static
     */
    public static function make(): self
    {
        return new self();
    }
}