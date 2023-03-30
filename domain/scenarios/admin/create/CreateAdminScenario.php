<?php

namespace domain\scenarios\admin\create;

use domain\entities\admin\AdminEntity;
use domain\entities\admin\AdminEntityDto;
use domain\entities\admin\exceptions\AdminNotValidException;
use domain\entities\admin\valueObjects\AdminName;
use domain\scenarios\_base\BaseResponse;
use domain\scenarios\_interfaces\PasswordGeneratorInterface;
use domain\scenarios\_interfaces\UniqueIdProviderInterface;
use domain\scenarios\admin\_interfaces\AdminDbRepositoryInterface;
use Throwable;

/**
 * Class CreateAdminScenario
 * @package domain\scenarios\admin\create
 */
class CreateAdminScenario
{
    /** @var UniqueIdProviderInterface */
    private UniqueIdProviderInterface $uniqueIdProvider;

    /** @var PasswordGeneratorInterface */
    private PasswordGeneratorInterface $passwordGenerator;

    /** @var AdminDbRepositoryInterface */
    private AdminDbRepositoryInterface $dbRepository;

    /**
     * @param UniqueIdProviderInterface $uniqueIdProvider
     * @param PasswordGeneratorInterface $passwordGenerator
     * @param AdminDbRepositoryInterface $dbRepository
     */
    public function __construct(UniqueIdProviderInterface $uniqueIdProvider, PasswordGeneratorInterface $passwordGenerator, AdminDbRepositoryInterface $dbRepository)
    {
        $this->uniqueIdProvider = $uniqueIdProvider;
        $this->passwordGenerator = $passwordGenerator;
        $this->dbRepository = $dbRepository;
    }

    /**
     * @param CreateAdminRequest $request
     * @return CreateAdminResponse
     * @throws AdminNotValidException
     * @throws Throwable
     */
    public function execute(CreateAdminRequest $request): BaseResponse
    {
        $adminEntityDto = $this->getAdminEntityDto($request);

        $this->dbRepository->beginTransaction();
        try {
            $entity = AdminEntity::create($adminEntityDto);
            $this->dbRepository->save($entity);
            $this->dbRepository->commitTransaction();
        } catch (Throwable $exception) {
            $this->dbRepository->rollbackTransaction();

            throw $exception;
        }

        return CreateAdminResponse::make($entity);
    }

    /**
     * @param CreateAdminRequest $request
     * @return AdminEntityDto
     */
    private function getAdminEntityDto(CreateAdminRequest $request): AdminEntityDto
    {
        $dto = new AdminEntityDto();
        $dto->id = $this->uniqueIdProvider->get();
        $dto->email = $request->email;
        $dto->login = $request->login;
        $dto->passwordHash = $this->passwordGenerator->generateHash($request->password);
        $dto->role = $request->role;
        $dto->name = new AdminName($request->firstName, $request->lastName, $request->middleName);

        return $dto;
    }
}