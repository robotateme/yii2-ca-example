<?php

use domain\scenarios\_interfaces\PasswordGeneratorInterface;
use domain\scenarios\admin\_interfaces\AdminDbRepositoryInterface;
use domain\scenarios\admin\signIn\_interfaces\SignInConfigProviderInterface;
use domain\scenarios\grandpay\user\_interfaces\UserDbRepositoryInterface;
use infra\common\PasswordGenerator;
use infra\common\providers\SignInConfigProvider;
use infra\db\repositories\AdminDbRepository;
use infra\grandpayDb\repositories\UserDbRepository;

return [
    'singletons' => [
        PasswordGeneratorInterface::class => PasswordGenerator::class,
        AdminDbRepositoryInterface::class => AdminDbRepository::class,
        UserDbRepositoryInterface::class => UserDbRepository::class,
        SignInConfigProviderInterface::class => SignInConfigProvider::class
    ]
];