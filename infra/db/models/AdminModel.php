<?php

namespace infra\db\models;

use domain\entities\admin\dictionaries\AdminValidationErrorsDictionary as ErrorsDictionary;
use yii\db\ActiveRecord;

/**
 * @property string $id
 * @property string $email
 * @property string $login
 * @property string $password_hash
 * @property int $role
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property bool $is_blocked
 * @property string $creation_date
 * @property string $block_date
 * @property string $last_update_date
 * @property string $last_login_date
 * @property string $access_token
 */
class AdminModel extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'admin';
    }

    public function rules(): array
    {
        return [
            [
                ['id', 'email', 'login', 'password_hash', 'role', 'first_name', 'last_name', 'is_blocked', 'creation_date'],
                'required',
                'message' => ErrorsDictionary::IS_NOT_FILLED
            ],
            [
                ['id', 'email', 'login'],
                'unique',
                'message' => ErrorsDictionary::IS_NOT_UNIQUE
            ],
            [
                'id',
                'string', 'length' => 32,
                'message' => ErrorsDictionary::IS_NOT_STRING, 'notEqual' => ErrorsDictionary::HAS_WRONG_LENGTH
            ],
            [
                ['email', 'login', 'password_hash', 'first_name', 'last_name', 'middle_name', 'access_token'],
                'string', 'max' => 255,
                'message' => ErrorsDictionary::IS_NOT_STRING, 'tooLong' => ErrorsDictionary::IS_TOO_LONG
            ],
            [
                ['creation_date', 'block_date', 'last_update_date', 'last_login_date', 'access_token_expiration_date'],
                'string',
                'message' => ErrorsDictionary::IS_NOT_STRING
            ],
            [
                ['access_token_can_expire', 'is_blocked'],
                'boolean',
                'message' => ErrorsDictionary::IS_NOT_BOOLEAN
            ],
        ];
    }
}