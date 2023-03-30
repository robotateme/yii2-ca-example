<?php

namespace app\models\forms;

use domain\scenarios\admin\unblock\UnblockAdminRequest;
use Yii;
use yii\base\Model;

class AdminUnblockForm extends Model
{
    /** @var string|null */
    public ?string $id = null;

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
                'id',
                'compare', 'compareValue' => Yii::$app->user->id, 'operator' => '!=',
                'message' => Yii::t('app', 'Нельзя разблокировать себя.')
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
        ];
    }

    /**
     * @return UnblockAdminRequest
     */
    public function getRequest(): UnblockAdminRequest
    {
        $request = new UnblockAdminRequest();
        $request->id = $this->id;

        return $request;
    }
}