<?php

namespace domain\scenarios\admin\_exceptions;

use domain\entities\admin\exceptions\AdminNotValidException;

class AdminNotValidDbException extends AdminNotValidException
{
    /** @var string */
    protected string $messageText = '[DB] Admin is not valid.';
}