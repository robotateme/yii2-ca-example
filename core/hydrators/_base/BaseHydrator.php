<?php

namespace core\hydrators\_base;

use core\hydrators\_interfaces\HydratorInterface;

/**
 * Class BaseHydrator
 * @package core\hydrators\_base
 */
abstract class BaseHydrator implements HydratorInterface
{
    /**
     * @var array
     */
    protected array $mapping = [];

    /**
     * @param array $mapping
     */
    public function __construct(array $mapping = [])
    {
        $this->mapping = $mapping;
    }
}