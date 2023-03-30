<?php

namespace domain\scenarios\admin\create;

/**
 * Class CreateAdminRequest
 * @package domain\scenarios\admin\create
 */
class CreateAdminRequest
{
    /** @var string */
    public ?string $email = null;
    /** @var string */
    public ?string $login = null;
    /** @var string */
    public ?string $password = null;
    /** @var int */
    public ?int $role = null;
    /** @var string */
    public ?string $firstName = null;
    /** @var string */
    public ?string $lastName = null;
    /** @var string|null */
    public ?string $middleName = null;
}