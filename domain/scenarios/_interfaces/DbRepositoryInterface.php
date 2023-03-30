<?php

namespace domain\scenarios\_interfaces;

/**
 * Interface DbRepositoryInterface
 *
 * @package domain\scenarios\_interfaces
 */
interface DbRepositoryInterface
{
    /**
     * Начинает транзакцию
     */
    public function beginTransaction(): void;

    /**
     * Закрывает транзакцию
     */
    public function commitTransaction(): void;

    /**
     * Откатывает транзакцию
     */
    public function rollbackTransaction(): void;
}