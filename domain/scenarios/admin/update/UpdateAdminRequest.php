<?php

namespace domain\scenarios\admin\update;

/**
 * Class UpdateAdminRequest
 * @package domain\scenarios\admin\update
 */
class UpdateAdminRequest
{
    /** @var string|null */
    public ?string $id = null;
    /** @var string|null */
    public ?string $email = null;
    /** @var string|null */
    public ?string $login = null;
    /** @var string|null */
    public ?string $password = null;
    /** @var int|null */
    public ?int $role = null;
    /** @var string|null */
    public ?string $firstName = null;
    /** @var string|null */
    public ?string $lastName = null;
    /** @var string|null */
    public ?string $middleName = null;
}