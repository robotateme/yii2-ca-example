<?php

namespace domain\scenarios\admin\getOne;

use domain\entities\admin\exceptions\AdminNotFoundException;
use domain\scenarios\admin\_interfaces\AdminDbRepositoryInterface;

/**
 * Class GetOneAdminScenario
 * @package domain\scenarios\admin\getOne
 */
class GetOneAdminScenario
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
     * @param GetOneAdminRequest $request
     * @return GetOneAdminResponse
     * @throws AdminNotFoundException
     */
    public function execute(GetOneAdminRequest $request): GetOneAdminResponse
    {
        $entity = $this->dbRepository->getOneById($request->id);

        if ($entity === null) {
            throw new AdminNotFoundException();
        }

        return GetOneAdminResponse::make($entity);
    }
}