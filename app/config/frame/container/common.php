<?php

use core\hydrators\_interfaces\HydratorInterface;
use core\hydrators\ReflectionHydrator;
use domain\scenarios\_interfaces\UniqueIdProviderInterface;
use infra\common\UniqueIdProvider;

return [
    'singletons' => [
        UniqueIdProviderInterface::class => UniqueIdProvider::class,
        HydratorInterface::class => ReflectionHydrator::class,
    ]
];