<?php

namespace app\components\response\_interfaces;

/**
 * Interface ApiResponseSchemaInterface
 * @package app\components\response\_interfaces
 */
interface ApiResponseSchemaInterface
{
    /**
     * @return array
     */
    public function toArray(): array;
}