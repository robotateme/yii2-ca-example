<?php

namespace domain\scenarios\admin\block;

use domain\entities\admin\exceptions\AdminNotFoundException;
use domain\entities\admin\exceptions\AdminNotValidException;
use domain\scenarios\admin\_interfaces\AdminDbRepositoryInterface;
use Throwable;

/**
 * Class BlockAdminScenario
 * @package domain\scenarios\admin\block
 */
class BlockAdminScenario
{
    /** @var AdminDbRepositoryInterface */
    private AdminDbRepositoryInterface $dbRepository;

    /**
     * @param AdminDbRepositoryInterface $dbRepository
     */
    public function __construct(AdminDbRepositoryInterface $dbRepository)
    {
        $this->dbRepository = $dbRepository;
    }

    /**
     * @param BlockAdminRequest $request
     * @return BlockAdminResponse
     * @throws AdminNotValidException
     * @throws Throwable
     */
    public function execute(BlockAdminRequest $request): BlockAdminResponse
    {
        $this->dbRepository->beginTransaction();
        try {
            $adminEntity = $this->dbRepository->getOneById($request->id);

            if ($adminEntity === null || $adminEntity->isBlocked() === true) {
                throw new AdminNotFoundException();
            }

            $adminEntity->block();
            $this->dbRepository->save($adminEntity);

            $this->dbRepository->commitTransaction();
        } catch (Throwable $exception) {
            $this->dbRepository->rollbackTransaction();

            throw $exception;
        }

        return BlockAdminResponse::make($adminEntity);
    }
}