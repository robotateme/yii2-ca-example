<?php

namespace domain\scenarios\grandpay\user\getList;

use domain\scenarios\grandpay\user\_interfaces\UserDbRepositoryInterface;
use Exception;

class GetListUserScenario
{
    /** @var UserDbRepositoryInterface */
    private UserDbRepositoryInterface $dbRepository;

    /**
     * @param UserDbRepositoryInterface $dbRepository
     */
    public function __construct(UserDbRepositoryInterface $dbRepository)
    {
        $this->dbRepository = $dbRepository;
    }

    /**
     * @throws Exception
     */
    public function execute(GetListUserRequest $request)
    {
        $entities = $this->dbRepository->getList($request->limit, $request->offset, (array) $request);
        $totalNumber = $this->dbRepository->getTotalNumber();
        return GetListUserResponse::make($request->limit, $request->offset, $totalNumber, $entities);
    }
}