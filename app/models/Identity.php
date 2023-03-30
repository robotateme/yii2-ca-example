<?php

namespace app\models;

use domain\scenarios\admin\_interfaces\AdminDbRepositoryInterface;
use Yii;
use yii\base\InvalidConfigException;
use yii\di\NotInstantiableException;
use yii\web\ForbiddenHttpException;
use yii\web\IdentityInterface;

class Identity implements IdentityInterface
{
    /** @var string|null */
    public ?string $id = null;

    /** @var int|null */
    public ?int $role = null;

    /** @var string|null */
    public ?string $accessToken = null;

    /**
     * @param string $id
     * @param string $accessToken
     * @param int $role
     */
    public function __construct(string $id, string $accessToken, int $role)
    {
        $this->id = $id;
        $this->accessToken = $accessToken;
        $this->role = $role;
    }

    public static function findIdentity($id)
    {
        echo 'find identity';
        die;
        // TODO: Implement findIdentity() method.
    }

    /**
     * @param $token
     * @param $type
     * @return static
     * @throws ForbiddenHttpException
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    public static function findIdentityByAccessToken($token, $type = null): self
    {
        if($token === null) {
            throw new ForbiddenHttpException();
        }

        /** @var AdminDbRepositoryInterface $dbRepository */
        $dbRepository = Yii::$container->get(AdminDbRepositoryInterface::class);
        $adminEntity = $dbRepository->getOneByAccessToken($token);

        if ($adminEntity === null || $adminEntity->isBlocked() === true) {
            throw new ForbiddenHttpException();
        }

        if ($adminEntity->isAccessTokenExpired()) {
            throw new ForbiddenHttpException();
        }

        return new self($adminEntity->getId(), $adminEntity->getAccessToken(), $adminEntity->getRole());
    }

    /**
     * @return int|string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $authKey
     * @return bool
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @return string
     */
    public function getAuthKey(): string
    {
        return $this->accessToken;
    }

}