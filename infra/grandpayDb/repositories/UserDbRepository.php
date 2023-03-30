<?php

namespace infra\grandpayDb\repositories;

use DateTime;
use domain\entities\grandpay\user\UserEntity;
use domain\entities\grandpay\user\UserEntityDto;
use domain\scenarios\grandpay\user\_interfaces\UserDbRepositoryInterface;
use Exception;
use infra\db\_base\BaseDbRepository;
use infra\grandpayDb\models\UserModel;

class UserDbRepository extends BaseDbRepository implements UserDbRepositoryInterface
{

    /**
     * @return string
     */
    protected static function getModelClass(): string
    {
        return UserModel::class;
    }

    /**
     * @param  int  $limit
     * @param  int  $offset
     * @param  array|null  $params
     * @return array|UserEntity[]
     * @throws Exception
     */
    public function getList(int $limit, int $offset, ?array $params = []): array
    {
        $query = UserModel::find()
            ->limit($limit)
            ->offset($offset)
        ;

        $query->filterWhere(['id' => $params['id'] ?? null]);
        $query->filterWhere(['email' => $params['email'] ?? null]);
        $query->filterWhere(['phone' => $params['phone'] ?? null]);
        $query->filterWhere(['firstName' => $params['firstName'] ?? null]);
        $query->filterWhere(['middleName' => $params['middleName'] ?? null]);
        $query->filterWhere(['lastName' => $params['lastName'] ?? null]);
        $query->filterWhere(['isBanned' => $params['isBanned'] ?? null]);
        $query->filterWhere(['createTime' => $params['createTime'] ?? null]);
        $query->filterWhere(['updateTime' => $params['updateTime'] ?? null]);
        $query->filterWhere(['referralCode' => $params['referralCode'] ?? null]);
        $query->filterWhere(['leaderReferralCode' => $params['leaderReferralCode'] ?? null]);
        $query->filterWhere(['city' => $params['city'] ?? null]);
        $query->filterWhere(['gender' => $params['gender'] ?? null]);
        $query->filterWhere(['birthdate' => $params['birthdate'] ?? null]);
        $query->filterWhere(['levelId' => $params['levelId'] ?? null]);

        $models = $query->all();
        $entities = [];
        foreach ($models as $model) {
            $entities[] = $this->convertModelToEntity($model);
        }

        return $entities;
    }

    /**
     * @param  UserModel  $model
     * @return UserEntity
     * @throws Exception
     */
    private function convertModelToEntity(UserModel $model): UserEntity
    {
        $dto = new UserEntityDto();
        $dto->id = $model->id;
        $dto->levelId = $model->levelId;
        $dto->email = $model->email;
        $dto->phone = $model->phone;
        $dto->city = $model->city;
        $dto->gender = $model->gender;
        $dto->birthdate = $model->birthdate;
        $dto->firstName = $model->firstName;
        $dto->middleName = $model->middleName;
        $dto->lastName = $model->lastName;
        $dto->isBanned = $model->isBanned;
        $dto->referralCode = $model->referralCode;
        $dto->leaderReferralCode = $model->leaderReferralCode;
        $dto->createTime = $model->createTime === null ? null : new DateTime($model->createTime);
        $dto->updateTime = $model->updateTime === null ? null : new DateTime($model->updateTime);

        return UserEntity::populate($dto);
    }

    /**
     * @param array|null $params
     * @return int
     */
    public function getTotalNumber(?array $params = []): int
    {
        return UserModel::find()->count();
    }
}