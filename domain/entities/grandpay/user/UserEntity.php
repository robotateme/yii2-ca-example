<?php

namespace domain\entities\grandpay\user;

use DateTime;
use Exception;

class UserEntity
{
    /** @var int */
    private int $id;

    /** @var int|null */
    private ?int $levelId;

    /** @var string|null */
    private ?string $email;

    /** @var string|null */
    private ?string $city;

    /** @var string|null */
    private ?string $birthdate;

    /** @var string|null */
    private ?string $gender;

    /** @var string|null */
    private ?string $phone;

    /** @var string|null */
    private ?string $firstName;

    /** @var string|null */
    private ?string $middleName;

    /** @var string|null */
    private ?string $lastName;

    /** @var bool */
    private bool $isBanned;

    /** @var DateTime */
    private DateTime $createTime;

    /** @var DateTime */
    private DateTime $updateTime;

    /** @var string */
    private string $referralCode;

    /** @var string|null */
    private ?string $leaderReferralCode;

    /**
     * @param  UserEntityDto  $dto
     * @throws Exception
     */
    private function __construct(UserEntityDto $dto)
    {
        $this->id = $dto->id;
        $this->levelId = $dto->levelId;
        $this->email = $dto->email;
        $this->city = $dto->city;
        $this->phone = $dto->phone;
        $this->gender = $dto->gender;
        $this->birthdate = $dto->birthdate;
        $this->firstName = $dto->firstName;
        $this->middleName = $dto->middleName;
        $this->lastName = $dto->lastName;
        $this->isBanned = $dto->isBanned;
        $this->referralCode = $dto->referralCode;
        $this->leaderReferralCode = $dto->leaderReferralCode;
        $this->createTime = $dto->createTime;
        $this->updateTime = $dto->updateTime;
    }

    /**
     * @throws Exception
     */
    public static function populate(UserEntityDto $dto)
    {
        return new self($dto);
    }

    /**
     * @return string
     */
    public function getReferralCode(): string
    {
        return $this->referralCode;
    }

    /**
     * @return string|null
     */
    public function getLeaderReferralCode(): ?string
    {
        return $this->leaderReferralCode;
    }

    /**
     * @return DateTime
     */
    public function getUpdateTime(): DateTime
    {
        return $this->updateTime;
    }

    /**
     * @return DateTime
     */
    public function getCreateTime(): DateTime
    {
        return $this->createTime;
    }

    /**
     * @return bool
     */
    public function isBanned(): bool
    {
        return $this->isBanned;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return string|null
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int|null
     */
    public function getLevelId(): ?int
    {
        return $this->levelId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @return string|null
     */
    public function getBirthdate(): ?string
    {
        return $this->birthdate;
    }


}