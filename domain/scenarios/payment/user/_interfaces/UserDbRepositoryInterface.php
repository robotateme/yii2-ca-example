<?php

namespace domain\scenarios\grandpay\user\_interfaces;

use domain\scenarios\_interfaces\DbRepositoryInterface;

interface UserDbRepositoryInterface extends DbRepositoryInterface
{
    /**
     * @param  int  $limit
     * @param  int  $offset
     * @param  array|null  $params
     * @return array
     */
    public function getList(int $limit, int $offset, ?array $params = []): array;

    public function getTotalNumber(array $params = []);
}