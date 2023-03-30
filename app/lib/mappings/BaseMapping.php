<?php

namespace app\lib\mappings;

/**
 * Class BaseMapping
 */
abstract class BaseMapping
{
    /**
     * @return array
     */
    abstract public static function getAll(): array;

    /**
     * @param mixed $key
     * @return mixed|null
     */
    public static function get($key)
    {
        return static::getAll()[$key] ?? null;
    }
}