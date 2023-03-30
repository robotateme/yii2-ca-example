<?php

namespace domain\scenarios\admin\getOne;

use domain\entities\admin\AdminEntity;
use domain\scenarios\_base\BaseResponse;

/**
 * Class GetOneAdminResponse
 * @package domain\scenarios\admin\getOne
 *
 * @OA\Schema(title="Get One Response", description="Возвращает одну модель Admin")
 */
class GetOneAdminResponse extends BaseResponse
{
    /**
     * @var string|null
     * @OA\Property(format="string", description="Идентификатор админа", title = "id")
     */
    public ?string $id;
    /**
     * @var string|null
     * @OA\Property(format="string", description="Электронная почта", title = "email")
     */
    public ?string $email;
    /**
     * @var string|null
     * @OA\Property(format="string", description="Логин админа", title = "login")
     */
    public ?string $login;
    /**
     * @var int|null
     * @OA\Property(format="integer", description="Роль юзера default(2=admin)", title = "role")
     */
    public ?int $role;
    /**
     * @var string|null
     * @OA\Property(format="string", description="Дата создани/регистрации админа", title = "creationDate")
     */
    public ?string $creationDate;
    /**
     * @var string|null
     * @OA\Property(format="string", description="Дата последнего входа", title = "lastLoginDate")
     */
    public ?string $lastLoginDate;
    /**
     * @var string|null
     * @OA\Property(format="string", description="Дата последнего обновления модели админа", title = "lastUpdateDate")
     */
    public ?string $lastUpdateDate;
    /**
     * @var string|null
     * @OA\Property(format="string", description="Имя администратора", title = "firstName")
     */
    public ?string $firstName;
    /**
     * @var string|null
     * @OA\Property(format="string", description="Фамилия администратора", title = "lastName")
     */
    public ?string $lastName;
    /**
     * @var string|null
     * @OA\Property(format="string", description="Отчество администратора", title = "middleName")
     */
    public ?string $middleName;
    /**
     * @var bool
     * @OA\Property(format="string", description="Статус администратора заблокирован/разблокирован", title = "isBlocked")
     */
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