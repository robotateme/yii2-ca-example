<?php

namespace domain\entities\grandpay\user;

use DateTime;

class UserEntityDto
{
    /** @var int|null */
    public ?int $id = null;

    /** @var int|null */
    public ?int $levelId = null;

    /** @var string|null */
    public ?string $email = null;

    /** @var string|null */
    public ?string $phone = null;

    /** @var string|null */
    public ?string $firstName = null;

    /** @var string|null */
    public ?string $middleName = null;

    /** @var string|null */
    public ?string $lastName = null;

    /** @var bool|null */
    public ?bool $isBanned = null;

    /** @var DateTime|null */
    public ?DateTime $createTime = null;

    /** @var DateTime|null */
    public ?DateTime $updateTime = null;

    /** @var string|null */
    public ?string $referralCode = null;

    /** @var string|null */
    public ?string $leaderReferralCode = null;

    /** @var string|null */
    public ?string $city = null;

    /** @var string|null */
    public ?string $gender = null;

    /** @var string|null */
    public ?string $birthdate = null;
}