<?php

namespace app\models\forms;


use domain\entities\grandpay\user\dictionaries\UserGenderDictionary;
use domain\scenarios\grandpay\user\getList\GetListUserRequest;
use yii\base\Model;

class UserGetListForm extends Model
{
    /** @var int */
    public const DEFAULT_LIMIT = 20;

    /** @var int */
    public const DEFAULT_OFFSET = 0;

    /** @var int|null */
    public ?int $limit = null;

    /** @var int|null */
    public ?int $offset = null;

    /** @var int|null */
    public ?int $id = null;

    /** @var int|null */
    public ?int $levelId = null;

    /** @var string|null */
    public ?string $email = null;

    /** @var string|null */
    public ?string $firstName = null;

    /** @var string|null */
    public ?string $middleName = null;

    /** @var string|null */
    public ?string $lastName = null;

    /** @var bool|null */
    public ?bool $isBanned = null;

    /** @var string|null */
    public ?string $referralCode = null;

    /** @var string|null */
    public ?string $leaderReferralCode = null;

    /** @var string|null */
    public ?string $createTime = null;

    /** @var string|null */
    public ?string $updateTime = null;

    /** @var string|null */
    public ?string $city = null;

    /** @var string|null */
    public ?string $birthdate = null;

    /** @var string|null */
    public ?string $phone = null;

    /** @var string|null */
    public ?string $gender = null;


    /**
     * @return array
     */
    public function rules() :array
    {
        return [
            [
                [
                    'firstName',
                    'middleName',
                    'lastName',
                    'email',
                    'city',
                    'phone',
                    'birthdate',
                    'gender',
                    'levelId',
                    'referralCode',
                    'leaderReferralCode',
                ],
                'string'
            ],
            [['email'], 'email'],
            ['birthdate', 'date', 'format' => 'php:Y-m-d'],
            [['levelId', 'id'], 'integer'],
            ['gender', 'in', 'range' => UserGenderDictionary::getAll()],
        ];
    }

    /**
     * @return GetListUserRequest
     */
    public function getRequest(): GetListUserRequest
    {
        $request = new GetListUserRequest();
        $request->limit = $this->limit ?? self::DEFAULT_LIMIT;
        $request->offset = $this->offset ?? self::DEFAULT_OFFSET;

        $request->updateTime = $this->updateTime;
        $request->createTime = $this->createTime;
        $request->city = $this->city;
        $request->isBanned = $this->isBanned;
        $request->referralCode = $this->referralCode;
        $request->leaderReferralCode = $this->leaderReferralCode;
        $request->birthdate = $this->birthdate;
        $request->email = $this->email;
        $request->phone = $this->phone;
        $request->gender = $this->gender;
        $request->firstName = $this->firstName;
        $request->middleName = $this->middleName;
        $request->lastName = $this->lastName;
        $request->id = $this->id;
        $request->levelId = $this->levelId;

        return $request;
    }
}