<?php

namespace domain\scenarios\admin\signIn;

use domain\entities\_base\_exceptions\EntityNotFoundException;
use domain\entities\admin\exceptions\AdminNotFoundException;
use domain\entities\admin\exceptions\AdminNotValidException;
use domain\scenarios\_interfaces\PasswordGeneratorInterface;
use domain\scenarios\admin\_interfaces\AdminDbRepositoryInterface;
use infra\common\providers\SignInConfigProvider;
use Throwable;

class SignInAdminScenario
{
    /** @var PasswordGeneratorInterface */
    private PasswordGeneratorInterface $passwordGenerator;

    /** @var AdminDbRepositoryInterface */
    private AdminDbRepositoryInterface $dbRepository;

    /** @var SignInConfigProvider */
    private SignInConfigProvider $configProvider;

    /**
     * @param PasswordGeneratorInterface $passwordGenerator
     * @param AdminDbRepositoryInterface $dbRepository
     */
    public function __construct(PasswordGeneratorInterface $passwordGenerator, AdminDbRepositoryInterface $dbRepository, SignInConfigProvider $configProvider)
    {
        $this->passwordGenerator = $passwordGenerator;
        $this->dbRepository = $dbRepository;
        $this->configProvider = $configProvider;
    }

    /**
     * @param SignInAdminRequest $request
     * @return SignInAdminResponse
     * @throws AdminNotValidException
     * @throws Throwable
     */
    public function execute(SignInAdminRequest $request): SignInAdminResponse
    {
        $this->dbRepository->beginTransaction();
        try {
            $adminEntity = $this->dbRepository->getOneByLogin($request->login);

            if ($adminEntity === null || $adminEntity->isBlocked() === true) {
                throw new AdminNotFoundException();
            }

            if ($this->passwordGenerator->verify($request->password, $adminEntity->getPasswordHash()) === false) {
                throw new AdminNotFoundException();
            }

            $accessTokenExpirationDate = $adminEntity->getAccessTokenExpirationDate();
            $accessToken = $this->passwordGenerator->generateRandomString(64);

            if ($request->accessTokenCanExpire === true) {
                $accessTokenExpirationDate = (new \DateTime())->modify($this->configProvider->getTokenExpirationTime());
            }

            $adminEntity->signIn($accessToken, $request->accessTokenCanExpire, $accessTokenExpirationDate);
            $this->dbRepository->save($adminEntity);

            $this->dbRepository->commitTransaction();
        } catch (Throwable $exception) {
            $this->dbRepository->rollbackTransaction();

            throw $exception;
        }

        return SignInAdminResponse::make($adminEntity);
    }
}