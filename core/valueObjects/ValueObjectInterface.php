<?php

namespace core\valueObjects;

/**
 * Interface ValueObjectInterface
 * @package domains\valueObjects
 */
interface ValueObjectInterface
{
    /**
     * @return string
     */
    public function __toString(): string;
}