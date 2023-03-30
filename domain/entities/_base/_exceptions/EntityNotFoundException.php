<?php

namespace domain\entities\_base\_exceptions;

use Exception;

/**
 * Class EntityNotFoundException
 * @package domain\entities\_base\_exceptions
 */
class EntityNotFoundException extends Exception
{
    /** @var string */
    protected string $messageText = '[Entity] not found.';

    /**
     * EntityNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct($this->messageText);
    }
}