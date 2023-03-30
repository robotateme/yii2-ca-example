<?php

namespace app\models\forms;

use domain\scenarios\admin\getList\GetListAdminRequest;
use yii\base\Model;

class AdminGetListForm extends Model
{
    /** @var int */
    public const DEFAULT_LIMIT = 20;

    /** @var int */
    public const DEFAULT_OFFSET = 0;

    /** @var int|null */
    public ?int $limit = null;

    /** @var int|null */
    public ?int $offset = null;

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [
                ['limit', 'offset'],
                'number', 'integerOnly' => true
            ]
        ];
    }

    /**
     * @return GetListAdminRequest
     */
    public function getRequest(): GetListAdminRequest
    {
        $request = new GetListAdminRequest();
        $request->limit = $this->limit ?? self::DEFAULT_LIMIT;
        $request->offset = $this->offset ?? self::DEFAULT_OFFSET;

        return $request;
    }
}