<?php

namespace domain\entities\admin;

use DateTime;
use domain\entities\admin\dictionaries\AdminPropertiesDictionary;
use domain\entities\admin\dictionaries\AdminRolesDictionary;
use domain\entities\admin\dictionaries\AdminValidationErrorsDictionary;
use domain\entities\admin\exceptions\AdminNotValidException;
use domain\entities\admin\valueObjects\AdminName;

class AdminEntity
{
    /** @var string */
    private string $id;

    /** @var string */
    private string $email;

    /** @var string */
    private string $login;

    /** @var string */
    private string $passwordHash;

    /** @var int */
    private int $role;

    /** @var AdminName */
    private AdminName $name;

    /** @var bool */
    private bool $isBlocked;

    /** @var DateTime */
    private DateTime $creationDate;

    /** @var DateTime|null */
    private ?DateTime $blockDate;

    /** @var DateTime|null */
    private ?DateTime $lastUpdateDate;

    /** @var DateTime|null */
    private ?DateTime $lastLoginDate;

    /** @var string|null */
    private ?string $accessToken;

    /** @var array */
    private array $_errors = [];

    /** @var DateTime|null */
    private ?DateTime $accessTokenExpirationDate;

    /** @var boolean */
    private bool $accessTokenCanExpire;

    /**
     * @param AdminEntityDto $dto
     * @throws AdminNotValidException
     */
    private function __construct(AdminEntityDto $dto)
    {
        $this->id = $dto->id;
        $this->email = $dto->email;
        $this->login = $dto->login;
        $this->passwordHash = $dto->passwordHash;
        $this->role = $dto->role;
        $this->name = $dto->name;
        $this->isBlocked = $dto->isBlocked;
        $this->creationDate = $dto->creationDate;
        $this->blockDate = $dto->blockDate;
        $this->lastUpdateDate = $dto->lastUpdateDate;
        $this->lastLoginDate = $dto->lastLoginDate;
        $this->accessToken = $dto->accessToken;
        $this->accessTokenCanExpire = $dto->accessTokenCanExpire;
        $this->accessTokenExpirationDate = $dto->accessTokenExpirationDate;

        $this->validate();
    }

    /**
     * @return void
     * @throws AdminNotValidException
     */
    private function validate(): void
    {
        $this->validateEmail();
        $this->validateRole();

        if (empty($this->_errors) === false) {
            throw new AdminNotValidException($this->_errors);
        }
    }

    /**
     * @return void
     */
    private function validateEmail(): void
    {
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->addError(AdminPropertiesDictionary::EMAIL, AdminValidationErrorsDictionary::EMAIL_NOT_VALID);
        }
    }

    /**
     * @param string $propertyName
     * @param string $error
     * @return void
     */
    private function addError(string $propertyName, string $error): void
    {
        $this->_errors[$propertyName][] = $error;
    }

    /**
     * @return void
     */
    private function validateRole(): void
    {
        if (in_array($this->role, AdminRolesDictionary::getAll()) === false) {
            $this->addError(AdminPropertiesDictionary::ROLE, AdminValidationErrorsDictionary::ROLE_NOT_FOUND);
        }
    }

    /**
     * @param AdminEntityDto $dto
     * @return static
     * @throws AdminNotValidException
     */
    public static function create(AdminEntityDto $dto): self
    {
        $dto->isBlocked = false;
        $dto->creationDate = $dto->creationDate ?? new DateTime();

        return new self($dto);
    }

    /**
     * @param AdminEntityDto $dto
     * @return static
     * @throws AdminNotValidException
     */
    public static function populate(AdminEntityDto $dto): self
    {
        return new self($dto);
    }

    /**
     * @param string $accessToken
     * @param bool $accessTokenCanExpire
     * @param null $accessTokenExpirationDate
     * @return void
     * @throws AdminNotValidException
     */
    public function signIn(string $accessToken, bool $accessTokenCanExpire = true, $accessTokenExpirationDate = null): void
    {
        $this->accessToken = $accessToken;
        $this->accessTokenCanExpire = $accessTokenCanExpire;
        $this->lastLoginDate = new DateTime();
        $this->lastUpdateDate = new DateTime();
        $this->accessTokenExpirationDate = $accessTokenExpirationDate;

        if (!$accessTokenCanExpire) {
            $this->accessTokenExpirationDate = null;
        }

        $this->validate();
    }

    /**
     * @return void
     * @throws AdminNotValidException
     */
    public function signOut(): void
    {
        $this->accessToken = null;
        $this->accessTokenCanExpire = true;
        $this->accessTokenExpirationDate = null;
        $this->lastUpdateDate = new DateTime();

        $this->validate();
    }

    /**
     * @return void
     * @throws AdminNotValidException
     */
    public function block(): void
    {
        $this->isBlocked = true;
        $this->accessToken = null;
        $this->lastUpdateDate = new DateTime();
        $this->blockDate = new DateTime();

        $this->validate();
    }

    /**
     * @return void
     * @throws AdminNotValidException
     */
    public function unblock(): void
    {
        $this->isBlocked = false;
        $this->lastUpdateDate = new DateTime();
        $this->blockDate = null;

        $this->validate();
    }

    /**
     * @param AdminEntityDto $dto
     * @return void
     * @throws AdminNotValidException
     */
    public function changePersonalData(AdminEntityDto $dto): void
    {
        $this->login = $dto->login ?? $this->login;
        $this->email = $dto->email ?? $this->email;
        $this->role = $dto->role ?? $this->role;
        $this->name = $dto->name ?? $this->name;
        $this->lastUpdateDate = new DateTime();

        if ($dto->passwordHash !== null) {
            $this->passwordHash = $dto->passwordHash;
            $this->accessToken = null;
        }

        $this->validate();
    }

    /**
     * @return bool
     */
    public function isAccessTokenExpired() : bool
    {
        if ($this->accessTokenCanExpire) {
            $dateNow = new DateTime();
            return $dateNow > $this->accessTokenExpirationDate;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
    }

    /**
     * @return int
     */
    public function getRole(): ?int
    {
        return $this->role;
    }

    /**
     * @return AdminName
     */
    public function getName(): ?AdminName
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isBlocked(): bool
    {
        return $this->isBlocked;
    }

    /**
     * @return DateTime
     */
    public function getCreationDate(): ?DateTime
    {
        return $this->creationDate;
    }

    /**
     * @return DateTime|null
     */
    public function getLastUpdateDate(): ?DateTime
    {
        return $this->lastUpdateDate;
    }

    /**
     * @return DateTime|null
     */
    public function getLastLoginDate(): ?DateTime
    {
        return $this->lastLoginDate;
    }

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * @return DateTime|null
     */
    public function getAccessTokenExpirationDate(): ?DateTime
    {
        return $this->accessTokenExpirationDate;
    }

    /**
     * @return bool
     */
    public function isAccessTokenCanExpire(): bool
    {
        return $this->accessTokenCanExpire;
    }

    /**
     * @return DateTime|null
     */
    public function getBlockDate(): ?DateTime
    {
        return $this->blockDate;
    }
}