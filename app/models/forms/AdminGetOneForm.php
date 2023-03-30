<?php

namespace app\models\forms;

use domain\scenarios\admin\getOne\GetOneAdminRequest;
use Yii;
use yii\base\Model;

class AdminGetOneForm extends Model
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
            ]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID')
        ];
    }

    /**
     * @return GetOneAdminRequest
     */
    public function getRequest(): GetOneAdminRequest
    {
        $request = new GetOneAdminRequest();
        $request->id = $this->id;

        return $request;
    }
}