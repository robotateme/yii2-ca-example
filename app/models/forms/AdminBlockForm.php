<?php

namespace app\models\forms;

use domain\scenarios\admin\block\BlockAdminRequest;
use Yii;
use yii\base\Model;

class AdminBlockForm extends Model
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
                'message' => Yii::t('app', 'Нельзя заблокировать себя.')
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
     * @return BlockAdminRequest
     */
    public function getRequest(): BlockAdminRequest
    {
        $request = new BlockAdminRequest();
        $request->id = $this->id;

        return $request;
    }
}