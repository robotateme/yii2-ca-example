<?php

namespace domain\entities\admin\exceptions;

use domain\entities\_base\_exceptions\EntityNotFoundException;

/**
 * Class AdminNotFoundException
 * @package domain\entities\admin\exceptions
 */
class AdminNotFoundException extends EntityNotFoundException
{
    /** @var string */
    protected string $messageText = '[Domain] Admin not found.';
}