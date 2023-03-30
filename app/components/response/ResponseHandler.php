<?php

namespace app\components\response;

use core\hydrators\exceptions\HydratorException;
use domain\entities\_base\_exceptions\EntityNotFoundException;
use domain\entities\_base\_exceptions\EntityNotValidException;
use Exception;
use Yii;
use yii\base\Event;
use yii\web\ForbiddenHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

/**
 * Class ResponseHandler
 * @package app\components
 */
class ResponseHandler
{
    /**
     * @param Event $event
     * @throws HydratorException
     * @throws Exception
     */
    public static function handle(Event $event): void
    {
        /** @var ApiResponse $sender */
        $sender = $event->sender;
        $exception = Yii::$app->errorHandler->exception;

        if ($exception === null) {
            $sender
                ->setData(['data' => $sender->data, 'error' => ApiResponseSchema::DEFAULT_ERROR], new ApiResponseSchema())
                ->success();
        } else {
            if ($exception instanceof EntityNotFoundException) {
                $sender
                    ->setData(['data' => null, 'error' => ApiResponseSchema::EMPTY_RESPONSE], new ApiResponseSchema())
                    ->failure(ApiResponse::STATUS_NOT_FOUND);
            } elseif ($exception instanceof EntityNotValidException) {
                $sender
                    ->setData(['data' => $exception->getErrors(), 'error' => ApiResponseSchema::VALIDATION_ERROR], new ApiResponseSchema())
                    ->failure(ApiResponse::STATUS_OK);
            } elseif ($exception instanceof UnauthorizedHttpException) {
                $sender
                    ->setData(['data' => null, 'error' => ApiResponseSchema::AUTHENTICATION_ERROR], new ApiResponseSchema())
                    ->failure(ApiResponse::STATUS_UNAUTHORIZED);
            } elseif ($exception instanceof ForbiddenHttpException) {
                $sender
                    ->setData(['data' => null, 'error' => ApiResponseSchema::AUTHORIZATION_ERROR], new ApiResponseSchema())
                    ->failure(ApiResponse::STATUS_FORBIDDEN);
            } elseif ($exception instanceof ValidationErrorException) {
                $sender
                    ->setData(['data' => $exception->validationErrors, 'error' => ApiResponseSchema::VALIDATION_ERROR], new ApiResponseSchema())
                    ->failure(ApiResponse::STATUS_UNPROCESSABLE_ENTITY);
            } elseif ($exception instanceof MethodNotAllowedHttpException) {
                $sender
                    ->setData(['data' => null, 'error' => ApiResponseSchema::EMPTY_RESPONSE], new ApiResponseSchema())
                    ->failure(ApiResponse::STATUS_NOT_FOUND);
            } elseif ($exception instanceof NotFoundHttpException) {
                $sender
                    ->setData(['data' => null, 'error' => ApiResponseSchema::EMPTY_RESPONSE], new ApiResponseSchema())
                    ->failure(ApiResponse::STATUS_NOT_FOUND);
            } elseif ($exception instanceof Exception) {
                if(YII_DEBUG === true) {
                    throw $exception;
                } else {
                    $sender
                        ->setData(['data' => null, 'error' => ApiResponseSchema::SERVER_ERROR], new ApiResponseSchema())
                        ->error(ApiResponse::STATUS_INTERNAL_ERROR);
                }
            }
        }
    }
}