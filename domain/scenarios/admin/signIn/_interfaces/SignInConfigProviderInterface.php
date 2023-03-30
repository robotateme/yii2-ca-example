<?php

namespace domain\scenarios\admin\signIn\_interfaces;

interface SignInConfigProviderInterface
{
    public function getTokenExpirationTime() : string;
}