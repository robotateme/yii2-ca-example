<?php

namespace infra\common;

use domain\scenarios\_interfaces\UniqueIdProviderInterface;
use Exception;

class UniqueIdProvider implements UniqueIdProviderInterface
{
    /** @var int */
    private int $length = 32;

    /**
     * @return string
     * @throws Exception
     */
    public function get(): string
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($this->length / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($this->length / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $this->length);
    }
}