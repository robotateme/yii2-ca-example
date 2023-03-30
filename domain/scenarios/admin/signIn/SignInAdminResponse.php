<?php

namespace domain\scenarios\admin\signIn;

use domain\entities\admin\AdminEntity;
use domain\scenarios\_base\BaseResponse;

/**
 * Class SignInAdminResponse
 * @package domain\scenarios\admin\signIn
 *
 * @OA\Schema(title="Sign In Response", description="Sign-In Admin Response Model")
 */
class SignInAdminResponse extends BaseResponse
{
    /**
     * @var string|null
     *
     * @OA\Property(format="string", description="Access Token", title = "Access Token")
     */
    public ?string $accessToken = null;

    /**
     * @param AdminEntity $entity
     * @return static
     */
    public static function make(AdminEntity $entity): self
    {
        $instance = new self();
        $instance->accessToken = $entity->getAccessToken();

        return $instance;
    }
}