<?php

namespace app\models\forms;

use app\lib\mappings\AdminErrorsMapping;
use domain\entities\admin\dictionaries\AdminPropertiesDictionary;
use domain\entities\admin\dictionaries\AdminRolesDictionary;
use domain\entities\admin\exceptions\AdminNotValidException;
use domain\scenarios\admin\update\UpdateAdminRequest;
use RuntimeException;
use Yii;
use yii\base\Model;

/**
 * Class AdminSignInForm
 * @package app\models\forms
 *
 * @OA\Schema(title="Admin Update Form", description="Форма изменения Администратора", required={"email", "login", "password", "passwordConfirmation", "firstName", "lastName", "middleName"})
 */
class AdminUpdateForm extends Model
{
    /**
     * @var string|null
     * @OA\Property(
     *      title="Id",
     *      property="id",
     *      type="string",
     *      example="9e5be81a02e85f3af95fd53fae597c39"
     * )
     */
    public ?string $id = null;

    /**
     * @var string|null
     * @OA\Property(
     *      title="Admin email",
     *      property="email",
     *      type="string",
     *      example="admin@example.test"
     * )
     */
    public ?string $email = null;

    /**
     * @var string|null
     * @OA\Property(
     *      title="Admin login",
     *      property="login",
     *      type="string",
     *      example="admin"
     * )
     */
    public ?string $login = null;

    /**
     * @var string|null
     * @OA\Property(
     *      title="Password",
     *      property="password",
     *      type="string",
     *      example="secret"
     * )
     */
    public ?string $password = null;

    /**
     * @var string|null
     * @OA\Property(
     *      title="Password confirmation",
     *      property="passwordConfirmation",
     *      type="string",
     *      example="secret"
     * )
     */
    public ?string $passwordConfirmation = null;

    /**
     * @var int|null
     * @OA\Property(
     *      title="Role",
     *      property="role",
     *      type="integer",
     *      example="secret"
     * )
     */
    public ?int $role = null;

    /**
     * @var string|null
     * @OA\Property(
     *      title="FirstName",
     *      property="firstName",
     *      type="string",
     *      example="John"
     * )
     */
    public ?string $firstName = null;

    /**
     * @var string|null
     * @OA\Property(
     *      title="LastName",
     *      property="lastName",
     *      type="string",
     *      example="Doe"
     * )
     */
    public ?string $lastName = null;

    /**
     * @var string|null
     * @OA\Property(
     *      title="middleName",
     *      property="middleName",
     *      type="string",
     *      example="N"
     * )
     */
    public ?string $middleName = null;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                'id',
                'required'
            ],
            [
                'id',
                'string', 'max' => 32
            ],
            [
                'email',
                'email'
            ],
            [
                ['email', 'login', 'password', 'passwordConfirmation', 'firstName', 'lastName', 'middleName'],
                'string', 'max' => 255
            ],
            [
                'role',
                'in', 'range' => AdminRolesDictionary::getAll()
            ],
            [
                'password',
                'compare', 'compareAttribute' => 'passwordConfirmation'
            ]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'E-mail'),
            'login' => Yii::t('app', 'Логин'),
            'password' => Yii::t('app', 'Пароль'),
            'passwordConfirmation' => Yii::t('app', 'Подтверждение пароля'),
            'role' => Yii::t('app', 'Роль'),
            'firstName' => Yii::t('app', 'Имя'),
            'lastName' => Yii::t('app', 'Фамилия'),
            'middleName' => Yii::t('app', 'Отчество'),
        ];
    }

    /**
     * @return UpdateAdminRequest
     */
    public function getRequest(): UpdateAdminRequest
    {
        $request = new UpdateAdminRequest();
        $request->id = $this->id;
        $request->email = $this->email;
        $request->login = $this->login;
        $request->password = $this->password;
        $request->role = $this->role;
        $request->firstName = $this->firstName;
        $request->lastName = $this->lastName;
        $request->middleName = $this->middleName;

        return $request;
    }

    /**
     * TODO нужно это вынести в какой-то базовый класс
     *
     * @param AdminNotValidException $exception
     */
    public function fillErrorsByException(AdminNotValidException $exception): void
    {
        $fieldsAssociations = [
            AdminPropertiesDictionary::LOGIN => 'login',
            AdminPropertiesDictionary::EMAIL => 'email',
            AdminPropertiesDictionary::ROLE => 'role'
        ];

        foreach ($exception->getErrors() as $property => $errors) {
            if (isset($fieldsAssociations[$property]) === false) {
                throw new RuntimeException("Property '$property' not isset in fieldsAssociations");
            }
            foreach ($errors as $error) {
                $this->addError($fieldsAssociations[$property], AdminErrorsMapping::get($error) ?? $error);
            }
        }
    }
}