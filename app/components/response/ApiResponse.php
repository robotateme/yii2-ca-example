<?php

namespace app\components\response;

use core\hydrators\_interfaces\HydratorInterface;
use core\hydrators\exceptions\HydratorException;
use core\hydrators\Hydrator;
use Yii;
use yii\base\InvalidConfigException;
use yii\di\NotInstantiableException;
use yii\web\Response;

/**
 * Class ApiResponse
 * @package app\components
 */
class ApiResponse extends Response
{
    /** @var int */
    const STATUS_OK = 200;
    /** @var int */
    const STATUS_CREATED = 201;
    /** @var int */
    const STATUS_NO_CONTENT = 204;

    /** @var int */
    const STATUS_BAD_REQUEST = 400;
    /** @var int */
    const STATUS_UNAUTHORIZED = 401;
    /** @var int */
    const STATUS_FORBIDDEN = 403;
    /** @var int */
    const STATUS_NOT_FOUND = 404;
    /** @var int */
    const STATUS_UNPROCESSABLE_ENTITY = 422;

    /** @var int */
    const STATUS_INTERNAL_ERROR = 500;
    /** @var int */
    const STATUS_BAD_GATEWAY = 502;

    /** @var string */
    public $format = Response::FORMAT_JSON;

    /** @var HydratorInterface */
    private HydratorInterface $hydrator;

    /**
     * ApiResponse constructor.
     * @param array $config
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->hydrator = Yii::$container->get(Hydrator::class);
    }

    /**
     * @param int $statusCode
     * @return ApiResponse
     */
    public function failure(int $statusCode = 400): ApiResponse
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param int $statusCode
     * @return ApiResponse
     */
    public function success(int $statusCode = 200): ApiResponse
    {
        $this->statusCode = $statusCode;

        return $this;

    }

    /**
     * @param int $statusCode
     * @return ApiResponse
     */
    public function error(int $statusCode = 500): ApiResponse
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param int $statusCode
     * @return ApiResponse
     */
    public function noContent(int $statusCode = 204): ApiResponse
    {
        $this->statusCode = $statusCode;
        $this->data = null;

        return $this;
    }

    /**
     * @throws HydratorException
     */
    public function setData(array $attributes, $object): ApiResponse
    {
        $this->data = $this->hydrator->hydrate($object, $attributes)->toArray();

        return $this;
    }
}