<?php

namespace core\valueObjects\user;

use core\valueObjects\ValueObjectInterface;

class UserName implements ValueObjectInterface
{
    /** @var string */
    private string $firstName;

    /** @var string */
    private string $lastName;

    /** @var string|null */
    private ?string $middleName = null;

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string|null $middleName
     */
    public function __construct(string $firstName, string $lastName, ?string $middleName = null)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
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
     * @return string
     */
    public function __toString(): string
    {
        return $this->getFullName();
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        if ($this->middleName !== null) {
            return sprintf('%s %s %s', $this->firstName, $this->middleName, $this->lastName);
        }

        return sprintf('%s %s', $this->firstName, $this->lastName);
    }
}