<?php

namespace domain\scenarios\admin\create;

use domain\entities\admin\AdminEntity;
use domain\scenarios\_base\BaseResponse;
use domain\scenarios\admin\getOne\GetOneAdminResponse;

/**
 * Class CreateAdminResponse
 * @package domain\scenarios\admin\create
 */
class CreateAdminResponse extends GetOneAdminResponse
{

    /**
     * @param AdminEntity $entity
     * @return static
     */
    public static function make(AdminEntity $entity): GetOneAdminResponse
    {
        return GetOneAdminResponse::make($entity);
    }
}