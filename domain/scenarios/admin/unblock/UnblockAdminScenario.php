<?php

namespace domain\scenarios\admin\unblock;

use domain\entities\admin\exceptions\AdminNotFoundException;
use domain\entities\admin\exceptions\AdminNotValidException;
use domain\scenarios\admin\_interfaces\AdminDbRepositoryInterface;
use Throwable;

/**
 * Class UnblockAdminScenario
 * @package domain\scenarios\admin\unblock
 */
class UnblockAdminScenario
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
     * @param UnblockAdminRequest $request
     * @return UnblockAdminResponse
     * @throws AdminNotValidException
     * @throws Throwable
     */
    public function execute(UnblockAdminRequest $request): UnblockAdminResponse
    {
        $this->dbRepository->beginTransaction();
        try {
            $adminEntity = $this->dbRepository->getOneById($request->id);

            if ($adminEntity === null || $adminEntity->isBlocked() === false) {
                throw new AdminNotFoundException();
            }

            $adminEntity->unblock();
            $this->dbRepository->save($adminEntity);

            $this->dbRepository->commitTransaction();
        } catch (Throwable $exception) {
            $this->dbRepository->rollbackTransaction();

            throw $exception;
        }

        return UnblockAdminResponse::make($adminEntity);
    }
}