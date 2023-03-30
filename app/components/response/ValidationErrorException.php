<?php

namespace app\components\response;

use Exception;
use yii\web\UnprocessableEntityHttpException;

/**
 * Class ValidationErrorException
 * @package app\components\exception
 */
class ValidationErrorException extends UnprocessableEntityHttpException
{
    /** @var array */
    public array $validationErrors = [];

    /**
     * ValidationErrorException constructor.
     * @param array $validationErrors
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(array $validationErrors, string $message = ApiResponseSchema::VALIDATION_ERROR, int $code = 0, Exception $previous = null)
    {
        $this->validationErrors = $validationErrors;
        parent::__construct($message, $code, $previous);
    }
}