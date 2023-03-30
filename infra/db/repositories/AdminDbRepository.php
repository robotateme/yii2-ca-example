<?php

namespace infra\db\repositories;

use core\helpers\ModelErrorsHelper;
use DateTime;
use domain\entities\admin\AdminEntity;
use domain\entities\admin\AdminEntityDto;
use domain\entities\admin\dictionaries\AdminPropertiesDictionary;
use domain\entities\admin\valueObjects\AdminName;
use domain\scenarios\admin\_exceptions\AdminNotValidDbException;
use domain\scenarios\admin\_interfaces\AdminDbRepositoryInterface;
use Exception;
use infra\db\_base\BaseDbRepository;
use infra\db\models\AdminModel;

class AdminDbRepository extends BaseDbRepository implements AdminDbRepositoryInterface
{
    /**
     * @return string
     */
    protected static function getModelClass(): string
    {
        return AdminModel::class;
    }

    /**
     * @param AdminEntity $entity
     * @return void
     * @throws AdminNotValidDbException
     */
    public function save(AdminEntity $entity): void
    {
        /** @var AdminModel $model */
        $model = AdminModel::find()
            ->where(['id' => $entity->getId()])
            ->one();


        $model = $this->convertEntityToModel($entity, $model);

        if ($model->validate() === false || $model->save() === false) {
            throw new AdminNotValidDbException($this->convertErrors($model));
        }
    }

    /**
     * @param AdminEntity $entity
     * @param AdminModel|null $model
     * @return AdminModel
     */
    private function convertEntityToModel(AdminEntity $entity, ?AdminModel $model = null): AdminModel
    {
        if ($model === null) {
            $model = new AdminModel();
            $model->id = $entity->getId();
        }

        $model->email = $entity->getEmail();
        $model->login = $entity->getLogin();
        $model->password_hash = $entity->getPasswordHash();
        $model->role = $entity->getRole();
        $model->is_blocked = $entity->isBlocked();
        $model->first_name = $entity->getName()->getFirstName();
        $model->last_name = $entity->getName()->getLastName();
        $model->middle_name = $entity->getName()->getMiddleName();
        $model->creation_date = $entity->getCreationDate()->format('Y-m-d H:i:s');
        $model->block_date = $entity->getBlockDate()? $entity->getBlockDate()->format('Y-m-d H:i:s') : null;
        $model->last_update_date = $entity->getLastUpdateDate() ? $entity->getLastUpdateDate()->format('Y-m-d H:i:s') : null;
        $model->last_login_date = $entity->getLastLoginDate() ? $entity->getLastLoginDate()->format('Y-m-d H:i:s') : null;
        $model->access_token_expiration_date = $entity->getAccessTokenExpirationDate() ? $entity->getAccessTokenExpirationDate()->format('Y-m-d H:i:s') : null;
        $model->access_token_can_expire = $entity->isAccessTokenCanExpire();

        $model->access_token = $entity->getAccessToken() ?? null;

        return $model;
    }

    /**
     * @param AdminModel $model
     * @return array
     */
    private function convertErrors(AdminModel $model): array
    {
        $associations = [
            'id' => AdminPropertiesDictionary::ID,
            'email' => AdminPropertiesDictionary::EMAIL,
            'login' => AdminPropertiesDictionary::LOGIN,
            'password_hash' => AdminPropertiesDictionary::PASSWORD_HASH,
            'role' => AdminPropertiesDictionary::ROLE,
            'is_blocked' => AdminPropertiesDictionary::IS_BLOCKED,
            'first_name' => AdminPropertiesDictionary::NAME,
            'last_name' => AdminPropertiesDictionary::NAME,
            'middle_name' => AdminPropertiesDictionary::NAME,
            'creation_date' => AdminPropertiesDictionary::CREATION_DATE,
            'block_date' => AdminPropertiesDictionary::BLOCK_DATE,
            'last_update_date' => AdminPropertiesDictionary::LAST_UPDATE_DATE,
            'last_login_date' => AdminPropertiesDictionary::LAST_LOGIN_DATE,
            'access_token' => AdminPropertiesDictionary::ACCESS_TOKEN,
        ];

        return ModelErrorsHelper::convert($associations, $model->getErrors());
    }

    /**
     * @param AdminEntity $entity
     * @return void
     */
    public function delete(AdminEntity $entity): void
    {
        AdminModel::deleteAll(['id' => $entity->getId()]);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param array|null $params
     * @return array|AdminEntity[]
     * @throws Exception
     */
    public function getList(int $limit, int $offset, ?array $params = []): array
    {
        $models = AdminModel::find()
            ->limit($limit)
            ->offset($offset)
            ->all();

        $entities = [];
        foreach ($models as $model) {
            $entities[] = $this->convertModelToEntity($model);
        }

        return $entities;
    }

    /**
     * @param AdminModel $model
     * @return AdminEntity
     * @throws Exception
     */
    private function convertModelToEntity(AdminModel $model): AdminEntity
    {
        $dto = new AdminEntityDto();
        $dto->id = $model->id;
        $dto->email = $model->email;
        $dto->login = $model->login;
        $dto->passwordHash = $model->password_hash;
        $dto->name = new AdminName($model->first_name, $model->last_name, $model->middle_name);
        $dto->role = $model->role;
        $dto->isBlocked = $model->is_blocked;
        $dto->accessToken = $model->access_token;
        $dto->creationDate = new DateTime($model->creation_date);
        $dto->blockDate = $model->block_date === null ? null : new DateTime($model->block_date);
        $dto->lastUpdateDate = $model->last_update_date === null ? null : new DateTime($model->last_update_date);
        $dto->lastLoginDate = $model->last_login_date === null ? null : new DateTime($model->last_login_date);
        $dto->accessTokenExpirationDate = $model->access_token_expiration_date === null ? null : new DateTime($model->access_token_expiration_date);
        $dto->accessTokenCanExpire = $model->access_token_can_expire;


        return AdminEntity::populate($dto);
    }

    /**
     * @param array|null $params
     * @return int
     */
    public function getTotalNumber(?array $params = []): int
    {
        return AdminModel::find()->count();
    }

    /**
     * @param string $id
     * @return AdminEntity|null
     * @throws Exception
     */
    public function getOneById(string $id): ?AdminEntity
    {
        /** @var AdminModel $model */
        $model = AdminModel::find()
            ->where(['id' => $id])
            ->one();

        if ($model === null) {
            return null;
        }

        return $this->convertModelToEntity($model);
    }

    /**
     * @param string $login
     * @return AdminEntity|null
     * @throws Exception
     */
    public function getOneByLogin(string $login): ?AdminEntity
    {
        /** @var AdminModel $model */
        $model = AdminModel::find()
            ->where(['login' => $login])
            ->one();

        if ($model === null) {
            return null;
        }

        return $this->convertModelToEntity($model);
    }

    /**
     * @param string $accessToken
     * @return AdminEntity|null
     * @throws Exception
     */
    public function getOneByAccessToken(string $accessToken): ?AdminEntity
    {
        /** @var AdminModel $model */
        $model = AdminModel::find()
            ->where(['access_token' => $accessToken])
            ->one();

        if ($model === null) {
            return null;
        }

        return $this->convertModelToEntity($model);
    }
}