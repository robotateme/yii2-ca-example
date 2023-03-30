<?php

namespace domain\entities\_base\_exceptions;

/**
 * Class EntityNotValidException
 * @package domain\entities\_base\_exceptions
 */
class EntityNotValidException extends \Exception
{
    /** @var string */
    protected string $messageText = '[Domain] [Entity] is not valid.';
    /** @var array */
    private array $errors = [];

    /**
     * @param array $errors
     */
    public function __construct(array $errors)
    {
        $this->errors = $errors;

        parent::__construct($this->messageText);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}