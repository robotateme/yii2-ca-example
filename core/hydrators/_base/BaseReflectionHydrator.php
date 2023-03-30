<?php

namespace core\hydrators\_base;

use core\hydrators\_interfaces\HydratorInterface;
use ReflectionClass;
use ReflectionException;

/**
 * Class BaseReflectionHydrator
 * @package core\hydrators\_base
 */
abstract class BaseReflectionHydrator implements HydratorInterface
{
    /**
     * @var array
     */
    protected array $reflectionClassMap = [];

    /**
     * @param ReflectionClass $reflection
     *
     * @return array
     */
    protected function getReflectionProperties(ReflectionClass $reflection): array
    {
        $properties = $reflection->getProperties();
        $result = [];
        if (empty($properties)) {
            return $result;
        }

        foreach ($properties as $property) {
            $result[] = $property->getName();
        }
        return $result;
    }

    /**
     * Returns instance of reflection class for class name passed
     *
     * @param string $className
     *
     * @return ReflectionClass
     * @throws ReflectionException
     */
    protected function getReflectionClass(string $className): ReflectionClass
    {
        if (!isset($this->reflectionClassMap[$className])) {
            $this->reflectionClassMap[$className] = new ReflectionClass($className);
        }
        return $this->reflectionClassMap[$className];
    }

}