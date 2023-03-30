<?php

namespace domain\scenarios\_interfaces;

interface PasswordGeneratorInterface
{
    /**
     * @param string $password
     * @return string
     */
    public function generateHash(string $password): string;

    /**
     * @param int $length
     * @return string
     */
    public function generateRandomString(int $length = 32): string;

    /**
     * @param string $password
     * @param string $hash
     * @return mixed
     */
    public function verify(string $password, string $hash);
}