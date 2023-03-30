<?php

namespace domain\entities\admin;

use DateTime;
use domain\entities\admin\valueObjects\AdminName;

class AdminEntityDto
{
    /** @var string|null */
    public ?string $id = null;

    /** @var string|null */
    public ?string $email = null;

    /** @var string|null */
    public ?string $login = null;

    /** @var string|null */
    public ?string $passwordHash = null;

    /** @var int|null */
    public ?int $role = null;

    /** @var AdminName|null */
    public ?AdminName $name = null;

    /** @var bool|null */
    public ?bool $isBlocked = null;

    /** @var DateTime|null */
    public ?DateTime $creationDate = null;

    /** @var DateTime|null */
    public ?DateTime $blockDate = null;

    /** @var DateTime|null */
    public ?DateTime $lastUpdateDate = null;

    /** @var DateTime|null */
    public ?DateTime $lastLoginDate = null;

    /** @var string|null */
    public ?string $accessToken = null;

    /** @var DateTime|null */
    public ?DateTime $accessTokenExpirationDate = null;

    /** @var boolean */
    public bool $accessTokenCanExpire = true;
}