<?php

namespace core\helpers;

/**
 * Class ModelErrorsConverter
 * @package core\helpers
 */
class ModelErrorsHelper
{
    /**
     * @param array $associations
     * @param array $modelErrors
     * @return array
     */
    public static function convert(array $associations, array $modelErrors): array
    {
        foreach ($modelErrors as $fieldName => $fieldErrors) {
            $result[$associations[$fieldName]] = $fieldErrors;
        }

        return $result;
    }
}