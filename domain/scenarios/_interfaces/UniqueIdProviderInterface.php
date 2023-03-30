<?php

namespace domain\scenarios\_interfaces;

interface UniqueIdProviderInterface
{
    /**
     * @return string
     */
    public function get(): string;
}