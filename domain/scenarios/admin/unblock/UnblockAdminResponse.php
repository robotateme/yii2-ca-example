<?php

namespace domain\scenarios\admin\unblock;

use domain\entities\admin\AdminEntity;
use domain\entities\admin\exceptions\AdminNotValidException;
use domain\scenarios\_base\BaseResponse;

/**
 * Class SignOutAdminResponse
 * @package domain\scenarios\admin\unblock
 *
 * @OA\Schema(title="Unblock Admin Response", description="Unblock Admin Response Model")
 */
class UnblockAdminResponse extends BaseResponse
{
    /**
     * @param AdminEntity $entity
     * @return static
     */
    public static function make(AdminEntity $entity): self
    {
        return new self();
    }
}