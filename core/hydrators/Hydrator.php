<?php

namespace core\hydrators;

use core\hydrators\_base\BaseHydrator;
use core\hydrators\exceptions\HydratorException;
use Exception;

/**
 * Class Hydrator
 * @package core\hydrators
 */
class Hydrator extends BaseHydrator
{

    /**
     * @inheritDoc
     * @throws HydratorException
     */
    public function hydrate($object, array $data): object
    {
        try {
            if (is_object($object)) {
                $className = get_class($object);
            } elseif (is_string($object) && class_exists($object)) {
                if (!class_exists($object)) {
                    throw new HydratorException("Given object '{$object}' must be valid class name.");
                }
                $className = $object;
                $object = new $className;
            } else {
                throw new HydratorException('Bad object property.');
            }

            foreach ($data as $propertyName => $propertyValue) {
                if (!property_exists($object, $propertyName)) {
                    throw new HydratorException("There's no '$propertyName' property in '$className'.");
                }
                $object->{$propertyName} = $propertyValue;
            }
            return $object;
        } catch (Exception $exception) {
            throw new HydratorException($exception->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function extract($object, array $properties = []): array
    {
        return (array)$object;
    }
}