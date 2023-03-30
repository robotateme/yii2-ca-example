<?php

namespace domain\scenarios\admin\update;

use domain\entities\admin\AdminEntity;
use domain\scenarios\_base\BaseResponse;

/**
 * Class UpdateAdminResponse
 * @package domain\scenarios\admin\update
 */
class UpdateAdminResponse extends BaseResponse
{
    /** @var string|null */
    public ?string $id;
    /** @var string|null */
    public ?string $email;
    /** @var string|null */
    public ?string $login;
    /** @var int|null */
    public ?int $role;
    /** @var string|null */
    public ?string $creationDate;
    /** @var string|null */
    public ?string $lastLoginDate;
    /** @var string|null */
    public ?string $lastUpdateDate;
    /** @var string|null */
    public ?string $firstName;
    /** @var string|null */
    public ?string $lastName;
    /** @var string|null */
    public ?string $middleName;
    /** @var bool */
    public bool $isBlocked;

    /**
     * @param AdminEntity $entity
     * @return static
     */
    public static function make(AdminEntity $entity): self
    {
        $instance = new self();
        $instance->id = $entity->getId();
        $instance->email = $entity->getEmail();
        $instance->login = $entity->getLogin();
        $instance->role = $entity->getRole();
        $instance->creationDate = $entity->getCreationDate() === null ? null : $entity->getCreationDate()->format(self::DATETIME_OUTPUT_FORMAT);
        $instance->lastLoginDate = $entity->getLastLoginDate() === null ? null : $entity->getLastLoginDate()->format(self::DATETIME_OUTPUT_FORMAT);
        $instance->lastUpdateDate = $entity->getLastUpdateDate() === null ? null : $entity->getLastUpdateDate()->format(self::DATETIME_OUTPUT_FORMAT);
        $instance->firstName = $entity->getName()->getFirstName();
        $instance->lastName = $entity->getName()->getLastName();
        $instance->middleName = $entity->getName()->getMiddleName();
        $instance->isBlocked = $entity->isBlocked();

        return $instance;
    }
}