<?php

namespace domain\scenarios\admin\getList;

use domain\entities\admin\AdminEntity;
use domain\scenarios\_base\BaseResponse;

/**
 * Class GetListAdminResponse
 * @package domain\scenarios\admin\getList
 *
 * @OA\Schema(title="Get List Response", description="Возвращает массив моделей Admin")
 */
class GetListAdminResponse extends BaseResponse
{
    /**
     * @var int|null
     * @OA\Property(format="integer", description="Лимит на выборку", title = "limit")
     */
    public ?int $limit;

    /**
     * @var int|null
     * @OA\Property(format="integer", description="Офсет на выборку", title = "offset")
     */
    public ?int $offset;

    /**
     * @OA\Property(format="iteger", description="Общее кол-во в списке", title = "totalNumber")
     * @var int|null
     */
    public ?int $totalNumber;

    /**
     * @OA\Schema(schema="GetListItems", title="Get List Items",
     *                  @OA\Property(
     *                      property="login",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="firstName",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="middleName",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="lastName",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="role",
     *                      type="int",
     *                  ),
     *                  @OA\Property(
     *                      property="isBlocked",
     *                      type="boolean",
     *                  ),
     *                  @OA\Property(
     *                      property="creationDate",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="lastLoginDate",
     *                      type="string",
     *                  ),
     *                  @OA\Property(
     *                      property="lastUpdatedDate",
     *                      type="string",
     *                  ),
     * )
     * @OA\Property(
     *     type="array",
     *      @OA\Items(
     *         type="array",
     *         @OA\Items(
     *             ref="#/components/schemas/GetListItems"
     *        )
     *      ),
     *     description="Список моделей Admin",
     *     title="items")
     * @var array
     */
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

        foreach ($entities as $entity) {
            $instance->items[] = [
                'id' => $entity->getId(),
                'email' => $entity->getEmail(),
                'login' => $entity->getLogin(),
                'role' => $entity->getRole(),
                'creationDate' => $entity->getCreationDate() === null ? null : $entity->getCreationDate()->format(self::DATETIME_OUTPUT_FORMAT),
                'lastLoginDate' => $entity->getLastLoginDate() === null ? null : $entity->getLastLoginDate()->format(self::DATETIME_OUTPUT_FORMAT),
                'lastUpdateDate' => $entity->getLastUpdateDate() === null ? null : $entity->getLastUpdateDate()->format(self::DATETIME_OUTPUT_FORMAT),
                'firstName' => $entity->getName()->getFirstName(),
                'lastName' => $entity->getName()->getLastName(),
                'middleName' => $entity->getName()->getMiddleName(),
                'isBlocked' => $entity->isBlocked(),
            ];
        }

        return $instance;
    }
}