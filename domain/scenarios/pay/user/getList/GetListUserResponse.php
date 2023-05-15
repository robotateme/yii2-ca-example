<?php

namespace domain\scenarios\grandpay\user\getList;

use domain\entities\admin\AdminEntity;
use domain\entities\grandpay\user\UserEntity;
use domain\scenarios\_base\BaseResponse;

/**
 * Class GetListAdminResponse
 * @package domain\scenarios\gateway\user\getList
 */
class GetListUserResponse extends BaseResponse
{
    /** @var int|null */
    public ?int $limit;

    /** @var int|null */
    public ?int $offset;

    /** @var int|null */
    public ?int $totalNumber;

    /** @var array */
    public array $items = [];
    /**
     * @param int $limit
     * @param int $offset
     * @param int $totalNumber
     * @param AdminEntity[] $entities
     * @return static
     */
    public static function make(int $limit, int $offset, int $totalNumber, array $entities): self
    {
        $instance = new self();
        $instance->limit = $limit;
        $instance->offset = $offset;
        $instance->totalNumber = $totalNumber;

        /** @var UserEntity $entity */
        foreach ($entities as $entity) {
            $instance->items[] = [
                'id' => $entity->getId(),
                'email' => $entity->getEmail(),
                'gender' => $entity->getGender(),
                'birthdate' => $entity->getBirthdate(),
                'phone' => $entity->getPhone(),
                'city' => $entity->getCity(),
                'isBanned' => $entity->isBanned(),
                'firstName' => $entity->getFirstName(),
                'middleName' => $entity->getMiddleName(),
                'lastName' => $entity->getLastName(),
                'levelId' => $entity->getLevelId(),
                'createTime' => $entity->getCreateTime() === null ? null : $entity->getCreateTime()->format(self::DATETIME_OUTPUT_FORMAT),
                'updateTime' => $entity->getCreateTime() === null ? null : $entity->getUpdateTime()->format(self::DATETIME_OUTPUT_FORMAT),
                'referralCode' => $entity->getReferralCode(),
                'leaderReferralCode' => $entity->getLeaderReferralCode(),
            ];
        }

        return $instance;
    }

}