<?php

namespace core\hydrators\_interfaces;

/**
 * Interface HydratorInterface
 * @package core\hydrators\_interfaces
 */
interface HydratorInterface
{

    /**
     * @param $object
     * @param array $data
     * @return mixed
     */
    public function hydrate($object, array $data);

    /**
     * @param $object
     * @param array $properties
     * @return mixed
     */
    public function extract($object, array $properties = []);
}