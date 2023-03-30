<?php

namespace domain\scenarios\admin\block;

use domain\entities\admin\AdminEntity;
use domain\entities\admin\exceptions\AdminNotValidException;
use domain\scenarios\_base\BaseResponse;

/**
 * Class SignOutAdminResponse
 * @package domain\scenarios\admin\block
 *
 * @OA\Schema(title="Block Admin Response", description="Block Admin Response Model")
 */
class BlockAdminResponse extends BaseResponse
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