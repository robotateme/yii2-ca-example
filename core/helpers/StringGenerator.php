<?php

namespace core\helpers;

/**
 * Class StringGenerator
 *
 * @package domains\valueObjects
 */
class StringGenerator
{
    /**
     * @var int
     */
    private const DEFAULT_LENGTH = 10;

    /**
     * @var string
     */
    private const DEFAULT_CHARSET = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @param int|null $length
     * @param string|null $charset
     *
     * @return string
     */
    public static function generate(?int $length = self::DEFAULT_LENGTH, ?string $charset = self::DEFAULT_CHARSET): string
    {
        $charsetLength = strlen($charset);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $charset[rand(0, $charsetLength - 1)];
        }

        return $string;
    }
}