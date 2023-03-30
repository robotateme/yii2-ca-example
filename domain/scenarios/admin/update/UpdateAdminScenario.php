<?php

namespace domain\scenarios\admin\update;

use domain\entities\admin\AdminEntityDto;
use domain\entities\admin\exceptions\AdminNotFoundException;
use domain\entities\admin\valueObjects\AdminName;
use domain\scenarios\_interfaces\PasswordGeneratorInterface;
use domain\scenarios\admin\_interfaces\AdminDbRepositoryInterface;
use Throwable;

/**
 * Class UpdateAdminScenario
 * @package domain\scenarios\admin\update
 */
class UpdateAdminScenario
{
    /** @var PasswordGeneratorInterface */
    private PasswordGeneratorInterface $passwordGenerator;

    /** @var AdminDbRepositoryInterface */
    private AdminDbRepositoryInterface $dbRepository;

    /**
     * @param PasswordGeneratorInterface $passwordGenerator
     * @param AdminDbRepositoryInterface $dbRepository
     */
    public function __construct(PasswordGeneratorInterface $passwordGenerator, AdminDbRepositoryInterface $dbRepository)
    {
        $this->passwordGenerator = $passwordGenerator;
        $this->dbRepository = $dbRepository;
    }

    /**
     * @param UpdateAdminRequest $request
     * @return UpdateAdminResponse
     */
    public function execute(UpdateAdminRequest $request): UpdateAdminResponse
    {
        $this->dbRepository->beginTransaction();
        try {
            $entity = $this->dbRepository->getOneById($request->id);

            if ($entity === null) {
                throw new AdminNotFoundException();
            }

            $dto = $this->getAdminEntityDto($request);
            $entity->changePersonalData($dto);
            $this->dbRepository->save($entity);

            $this->dbRepository->commitTransaction();
        } catch (Throwable $exception) {
            $this->dbRepository->rollbackTransaction();

            throw $exception;
        }

        return UpdateAdminResponse::make($entity);
    }

    /**
     * @param UpdateAdminRequest $request
     * @return AdminEntityDto
     */
    private function getAdminEntityDto(UpdateAdminRequest $request): AdminEntityDto
    {
        $dto = new AdminEntityDto();
        $dto->email = $request->email;
        $dto->login = $request->login;
        $dto->role = $request->role;

        if ($request->password !== null) {
            $dto->passwordHash = $this->passwordGenerator->generateHash($request->password);
        }

        if ($request->lastName !== null && $request->firstName !== null) {
            $dto->name = new AdminName($request->firstName, $request->lastName, $request->middleName);
        }

        return $dto;
    }
}