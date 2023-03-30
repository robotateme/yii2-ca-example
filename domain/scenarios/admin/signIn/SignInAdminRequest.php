<?php

namespace domain\scenarios\admin\signIn;

/**
 * Class SignInAdminRequest
 * @package domain\scenarios\admin\signIn
 */
class SignInAdminRequest
{
    /** @var string */
    public string $login;
    /** @var string */
    public string $password;
    /** @var boolean */
    public bool $accessTokenCanExpire = false;
}