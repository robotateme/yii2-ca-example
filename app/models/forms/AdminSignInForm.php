<?php

namespace app\models\forms;

use domain\scenarios\admin\signIn\SignInAdminRequest;
use Yii;
use yii\base\Model;

/**
 * Class AdminSignInForm
 * @package app\models\forms
 *
 * @OA\Schema(title="Sign In Form", description="Sign-In Admin Form Model", required={"login", "password"})
 */
class AdminSignInForm extends Model
{
    /**
     * @OA\Property(format="string", description="Admin login", title="Admin Login")
     * @var string|null
     */
    public ?string $login = null;

    /**
     * @OA\Property(format="string", description="Admin password", title="Admin password")
     * @var string|null
     */
    public ?string $password = null;

    /** @var boolean */
    public bool $rememberMe = false;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                ['login', 'password'],
                'required'
            ],
            [
                ['login', 'password'],
                'string', 'max' => 255
            ],
            [
                ['rememberMe'],
                'boolean'
            ]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'login' => Yii::t('app', 'Логин'),
            'password' => Yii::t('app', 'Пароль'),
            'rememberMe' => Yii::t('app', 'Запомнить меня'),
        ];
    }

    /**
     * @return SignInAdminRequest
     */
    public function getRequest(): SignInAdminRequest
    {
        $request = new SignInAdminRequest();
        $request->login = $this->login;
        $request->password = $this->password;
        $request->accessTokenCanExpire = !$this->rememberMe;

        return $request;
    }
}