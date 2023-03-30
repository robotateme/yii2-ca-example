<?php

namespace app\controllers;

use app\components\response\ValidationErrorException;
use app\models\forms\AdminBlockForm;
use app\models\forms\AdminCreateForm;
use app\models\forms\AdminGetListForm;
use app\models\forms\AdminGetOneForm;
use app\models\forms\AdminUnblockForm;
use app\models\forms\AdminUpdateForm;
use domain\entities\admin\exceptions\AdminNotFoundException;
use domain\entities\admin\exceptions\AdminNotValidException;
use domain\scenarios\admin\block\BlockAdminResponse;
use domain\scenarios\admin\block\BlockAdminScenario;
use domain\scenarios\admin\create\CreateAdminResponse;
use domain\scenarios\admin\create\CreateAdminScenario;
use domain\scenarios\admin\getList\GetListAdminResponse;
use domain\scenarios\admin\getList\GetListAdminScenario;
use domain\scenarios\admin\getOne\GetOneAdminResponse;
use domain\scenarios\admin\getOne\GetOneAdminScenario;
use domain\scenarios\admin\unblock\UnblockAdminResponse;
use domain\scenarios\admin\unblock\UnblockAdminScenario;
use domain\scenarios\admin\update\UpdateAdminResponse;
use domain\scenarios\admin\update\UpdateAdminScenario;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\di\NotInstantiableException;
use yii\helpers\ArrayHelper;

class AdminController extends BaseRestController
{
    /**
     * @return array|string[][]
     */
    public function verbs(): array
    {
        return ArrayHelper::merge(parent::verbs(), [
            'block' => ['PUT'],
            'unblock' => ['PUT'],
            'create' => ['POST'],
            'update' => ['PUT'],
            'get-list' => ['GET'],
            'get-one' => ['GET'],
        ]);
    }

    /**
     * @OA\Put  (
     *      path="/api/v1/admin/block/{id}",
     *      summary="Блокировка пользователя",
     *      operationId="block",
     *      tags={"block"},
     *      @OA\Parameter(
     *         description="Идентификатор Администратора",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="uuid"
     *         )
     *      ),
     *      @OA\Header(
     *          required=true,
     *          description="Authorization (Bearer) Header",
     *          header="Autorization",
     *      ),
     *     @OA\Response(response=200, description="Положительный ответ на запрос"),
     *     @OA\Response(response=422, description="Ошибка валидации"),
     *     @OA\Response(response=500, description="Внутреняя ошибка сервера"),
     * )
     * @param string $id
     * @return BlockAdminResponse
     * @throws AdminNotValidException
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     * @throws Throwable
     * @throws ValidationErrorException
     */
    public function actionBlock(string $id)
    {
        $formModel = new AdminBlockForm();
        $formModel->id = $id;

        if ($formModel->validate() === false) {
            throw new ValidationErrorException($formModel->errors);
        }

        $scenario = Yii::$container->get(BlockAdminScenario::class);

        return $scenario->execute($formModel->getRequest());
    }

    /**
     * @OA\Post  (
     *      path="/api/v1/admin",
     *      summary="Создание пользователя",
     *      operationId="createUser",
     *      tags={"create-admin"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/AdminCreateForm")
     *          )
     *      ),
     *      @OA\Header(
     *          required=true,
     *          description="Authorization (Bearer) Header",
     *          header="Autorization",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Положительный ответ на запрос",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(
     *                      property="data",
     *                      ref="#/components/schemas/GetOneAdminResponse"
     *                  ),
     *                  @OA\Property(
     *                      property="error",
     *                      type="bool"
     *                  )
     *              )
     *          )
     *      ),
     *     @OA\Response(response=422, description="Ошибка валидации"),
     *     @OA\Response(response=500, description="Внутреняя ошибка сервера"),
     * )
     * @return CreateAdminResponse
     * @throws AdminNotValidException
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     * @throws Throwable
     * @throws ValidationErrorException
     */
    public function actionCreate()
    {
        $formModel = new AdminCreateForm(Yii::$app->request->getBodyParams());

        if ($formModel->validate() === false) {
            throw new ValidationErrorException($formModel->errors);
        }

        $scenario = Yii::$container->get(CreateAdminScenario::class);

        try {
            $response = $scenario->execute($formModel->getRequest());
        } catch (AdminNotValidException $exception) {
            $formModel->fillErrorsByException($exception);

            throw new ValidationErrorException($formModel->errors);
        }

        return $response;
    }

    /**
     * @OA\Get (
     *      path="/api/v1/admin/get-list",
     *      summary="Список пользователей",
     *      operationId="getAdminList",
     *      tags={"get-admin-list"},
     *      @OA\Header(
     *          required=true,
     *          description="Authorization (Bearer) Header",
     *          header="Autorization",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Положительный ответ на запрос",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(
     *                      property="data",
     *                      ref="#/components/schemas/GetListAdminResponse"
     *                  ),
     *                  @OA\Property(
     *                      property="error",
     *                      type="bool"
     *                  )
     *              )
     *          )
     *      ),
     *     @OA\Response(response=422, description="Ошибка валидации"),
     *     @OA\Response(response=500, description="Внутреняя ошибка сервера"),
     * )
     *
     * @return GetListAdminResponse
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     * @throws ValidationErrorException
     */
    public function actionGetList()
    {
        $formModel = new AdminGetListForm(Yii::$app->request->get());

        if ($formModel->validate() === false) {
            throw new ValidationErrorException($formModel->errors);
        }

        $scenario = Yii::$container->get(GetListAdminScenario::class);
        return $scenario->execute($formModel->getRequest());
    }

    /**
     * @OA\Get (
     *      path="/api/v1/admin/{id}",
     *      summary="Получение данных о пользователе",
     *      operationId="getUser",
     *      tags={"get-one"},
     *      @OA\Parameter(
     *         description="Идентификатор пользователя",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="uuid"
     *         )
     *      ),
     *      @OA\Header(
     *          required=true,
     *          description="Authorization (Bearer) Header",
     *          header="Autorization",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Положительный ответ на запрос",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(
     *                      property="data",
     *                      ref="#/components/schemas/GetOneAdminResponse"
     *                  ),
     *                  @OA\Property(
     *                      property="error",
     *                      type="bool"
     *                  )
     *              )
     *          )
     *      ),
     *     @OA\Response(response=422, description="Ошибка валидации"),
     *     @OA\Response(response=500, description="Внутреняя ошибка сервера"),
     * )
     *
     * @param string $id
     * @return GetOneAdminResponse
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     * @throws ValidationErrorException
     * @throws AdminNotFoundException
     */
    public function actionGetOne(string $id)
    {
        $formModel = new AdminGetOneForm();
        $formModel->id = $id;

        if ($formModel->validate() === false) {
            throw new ValidationErrorException($formModel->errors);
        }

        $scenario = Yii::$container->get(GetOneAdminScenario::class);
        return $scenario->execute($formModel->getRequest());
    }


    /**
     * @OA\Put (
     *      path="/api/v1/admin/unblock/{id}",
     *      summary="Разблокировка",
     *      operationId="unblock",
     *      tags={"unblock"},
     *      @OA\Parameter(
     *         description="Идентификатор пользователя",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="uuid"
     *         )
     *      ),
     *      @OA\Header(
     *          required=true,
     *          description="Authorization (Bearer) Header",
     *          header="Autorization",
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="Положительный ответ на запрос",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(
     *                      property="data",
     *                      ref="#/components/schemas/UnblockAdminResponse"
     *                  ),
     *                  @OA\Property(
     *                      property="error",
     *                      type="bool"
     *                  )
     *              )
     *          )
     *      ),
     *     @OA\Response(response=422, description="Ошибка валидации"),
     *     @OA\Response(response=500, description="Внутреняя ошибка сервера"),
     * )
     * @param string $id
     * @return UnblockAdminResponse
     * @throws AdminNotValidException
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     * @throws Throwable
     * @throws ValidationErrorException
     */
    public function actionUnblock(string $id)
    {
        $formModel = new AdminUnblockForm();
        $formModel->id = $id;

        if ($formModel->validate() === false) {
            throw new ValidationErrorException($formModel->errors);
        }

        $scenario = Yii::$container->get(UnblockAdminScenario::class);

        return $scenario->execute($formModel->getRequest());
    }

    /**
     * @OA\Put (
     *      path="/api/v1/admin/{id}",
     *      summary="Обновление пользователя",
     *      operationId="updateUser",
     *      tags={"update-admin"},
     *      @OA\Parameter(
     *         description="Идентификатор пользователя",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="uuid"
     *         )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Updated admin object",
     *      @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/AdminUpdateForm")
     *          ),
     *      ),
     *      @OA\Header(
     *          required=true,
     *          description="Authorization (Bearer) Header",
     *          header="Autorization",
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Положительный ответ на запрос",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(
     *                      property="data",
     *                      ref="#/components/schemas/GetOneAdminResponse"
     *                  ),
     *                  @OA\Property(
     *                      property="error",
     *                      type="bool"
     *                  )
     *              )
     *          )
     *      ),
     *     @OA\Response(response=422, description="Ошибка валидации"),
     *     @OA\Response(response=500, description="Внутреняя ошибка сервера"),
     * )
     * @param string $id
     * @return UpdateAdminResponse
     * @throws AdminNotFoundException
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     * @throws Throwable
     * @throws ValidationErrorException
     */
    public function actionUpdate(string $id)
    {
        $formModel = new AdminUpdateForm(Yii::$app->request->getBodyParams());
        $formModel->id = $id;

        if ($formModel->validate() === false) {
            throw new ValidationErrorException($formModel->errors);
        }

        $scenario = Yii::$container->get(UpdateAdminScenario::class);

        try {
            $response = $scenario->execute($formModel->getRequest());
        } catch (AdminNotValidException $exception) {
            $formModel->fillErrorsByException($exception);

            throw new ValidationErrorException($formModel->errors);
        }

        return $response;
    }
}