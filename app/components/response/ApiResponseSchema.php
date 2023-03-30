<?php

namespace app\components\response;

use app\components\response\_interfaces\ApiResponseSchemaInterface;

/**
 * @OA\Schema(
 *     description="Api response",
 *     title="Api response"
 * )
 * Class ApiResponseSchema
 * @package app\components\response
 */
class ApiResponseSchema extends BaseApiResponseSchema
{
    /** @var string */
    const AUTHORIZATION_ERROR = 'authorization_error';
    /** @var string */
    const AUTHENTICATION_ERROR = 'authentication_error';
    /** @var string */
    const VALIDATION_ERROR = 'validation_error';
    /** @var string */
    const EMPTY_RESPONSE = 'empty_response';
    /** @var string */
    const SERVER_ERROR = 'server_error';

    /** @var bool */
    const DEFAULT_ERROR = false;

    /**
     * @OA\Property(
     *     description="Данные ответа API или список ошибок",
     *     title="Data",
     * )
     * @var mixed
     */
    public $data = null;

    /**
     * @OA\Property(
     *     description="Название/тип ошибки или false",
     *     title="Error",
     * )
     *
     * @var mixed
     */
    public $error = false;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'error' => $this->error,
        ];
    }
}