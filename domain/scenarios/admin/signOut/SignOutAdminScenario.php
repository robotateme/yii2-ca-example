<?php

namespace domain\scenarios\admin\signOut;

use domain\entities\admin\exceptions\AdminNotValidException;
use domain\scenarios\admin\_interfaces\AdminDbRepositoryInterface;
use Throwable;

/**
 * Class SignOutAdminScenario
 * @package domain\scenarios\admin\signOut
 */
class SignOutAdminScenario
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
     * @param SignOutAdminRequest $request
     * @return SignOutAdminResponse
     * @throws AdminNotValidException
     * @throws Throwable
     */
    public function execute(SignOutAdminRequest $request): SignOutAdminResponse
    {
        $this->dbRepository->beginTransaction();
        try {
            $adminEntity = $this->dbRepository->getOneById($request->id);
            $adminEntity->signOut();
            $this->dbRepository->save($adminEntity);
            $this->dbRepository->commitTransaction();
        } catch (Throwable $exception) {
            $this->dbRepository->rollbackTransaction();

            throw $exception;
        }

        return SignOutAdminResponse::make();
    }
}