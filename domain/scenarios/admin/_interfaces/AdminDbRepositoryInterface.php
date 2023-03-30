<?php

namespace domain\scenarios\admin\_interfaces;

use domain\entities\admin\AdminEntity;
use domain\scenarios\_interfaces\DbRepositoryInterface;

interface AdminDbRepositoryInterface extends DbRepositoryInterface
{
    /**
     * @param AdminEntity $entity
     * @return void
     */
    public function save(AdminEntity $entity): void;

    /**
     * @param string $id
     * @return AdminEntity|null
     */
    public function getOneById(string $id): ?AdminEntity;

    /**
     * @param string $login
     * @return AdminEntity|null
     */
    public function getOneByLogin(string $login): ?AdminEntity;

    /**
     * @param string $accessToken
     * @return AdminEntity|null
     */
    public function getOneByAccessToken(string $accessToken): ?AdminEntity;

    /**
     * @param array|null $params
     * @return int
     */
    public function getTotalNumber(?array $params = []): int;

    /**
     * @param int $limit
     * @param int $offset
     * @param array|null $params
     * @return AdminEntity[]
     */
    public function getList(int $limit, int $offset, ?array $params = []): array;
}