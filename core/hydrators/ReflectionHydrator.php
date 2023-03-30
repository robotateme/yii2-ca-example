<?php

namespace core\hydrators;

use core\hydrators\_base\BaseReflectionHydrator;
use core\hydrators\exceptions\HydratorException;
use ReflectionException;

/**
 * Class ReflectionHydrator
 * @package core\hydrators
 */
class ReflectionHydrator extends BaseReflectionHydrator
{
    /**
     * @throws HydratorException
     */
    public function hydrate($object, array $data)
    {
        try {
            if (is_object($object)) {
                $className = get_class($object);
                $reflection = $this->getReflectionClass($className);
            } elseif (is_string($object) && class_exists($object)) {
                if (!class_exists($object)) {
                    throw new HydratorException("Given object '{$object}' must be valid class name.");
                }
                $className = $object;
                $reflection = $this->getReflectionClass($className);
                $object = $reflection->newInstanceWithoutConstructor();
            } else {
                throw new HydratorException('Bad object property.');
            }
            foreach ($data as $propertyName => $propertyValue) {
                if (!$reflection->hasProperty($propertyName)) {
                    throw new HydratorException("There's no '$propertyName' property in '$className'.");
                }
                $property = $reflection->getProperty($propertyName);
                if ($property->isStatic()) {
                    continue;
                }
                $property->setAccessible(true);
                $property->setValue($object, $propertyValue);
            }
            return $object;
        } catch (ReflectionException $exception) {
            throw new HydratorException($exception->getMessage());
        }
    }

    /**
     * @throws HydratorException
     */
    public function extract($object, array $properties = []): array
    {
        try {
            $data = [];
            $className = get_class($object);
            $reflection = $this->getReflectionClass($className);
            if ([] === $properties) {
                $properties = $this->getReflectionProperties($reflection);
            }
            foreach ($properties as $propertyName) {
                if ($reflection->hasProperty($propertyName)) {
                    $property = $reflection->getProperty($propertyName);
                    if ($property->isStatic()) {
                        continue;
                    }
                    $property->setAccessible(true);
                    $data[$propertyName] = $property->getValue($object);
                }
            }
            return $data;
        } catch (ReflectionException $exception) {
            throw new HydratorException($exception->getMessage());
        }
    }

}