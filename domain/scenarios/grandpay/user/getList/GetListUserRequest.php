<?php

namespace domain\scenarios\grandpay\user\getList;

class GetListUserRequest
{
    /** @var int|null */
    public ?int $limit = null;

    /** @var int|null */
    public ?int $offset = null;

    /** @var int|null */
    public ?int $id;

    /** @var int|null */
    public ?int $levelId;

    /** @var string|null */
    public ?string $email;

    /** @var string|null */
    public ?string $firstName;

    /** @var string|null */
    public ?string $middleName;

    /** @var string|null */
    public ?string $lastName;

    /** @var bool|null */
    public ?bool $isBanned;

    /** @var string|null */
    public ?string $referralCode;

    /** @var string|null */
    public ?string $leaderReferralCode;

    /** @var string|null */
    public ?string $createTime;

    /** @var string|null */
    public ?string $updateTime;

    /** @var string|null */
    public ?string $city;

    /** @var string|null */
    public ?string $birthdate;

    /** @var string|null */
    public ?string $phone;

    /** @var string|null */
    public ?string $gender;

}