<?php

namespace domain\entities\admin\exceptions;

use domain\entities\_base\_exceptions\EntityNotValidException;

/**
 * Class AdminNotValidException
 * @package domain\entities\admin\exceptions
 */
class AdminNotValidException extends EntityNotValidException
{
    /** @var string */
    protected string $messageText = '[Domain] Admin is not valid.';
}