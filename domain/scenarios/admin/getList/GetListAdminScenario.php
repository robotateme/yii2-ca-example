<?php

namespace domain\scenarios\admin\getList;

use domain\scenarios\admin\_interfaces\AdminDbRepositoryInterface;

/**
 * Class GetListAdminScenario
 * @package domain\scenarios\admin\getList
 */
class GetListAdminScenario
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
     * @param GetListAdminRequest $request
     * @return GetListAdminResponse
     */
    public function execute(GetListAdminRequest $request): GetListAdminResponse
    {
        $entities = $this->dbRepository->getList($request->limit, $request->offset);
        $totalNumber = $this->dbRepository->getTotalNumber();

        return GetListAdminResponse::make($request->limit, $request->offset, $totalNumber, $entities);
    }
}