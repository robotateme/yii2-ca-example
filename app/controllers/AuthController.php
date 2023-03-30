<?php

namespace app\controllers;

use app\components\response\ValidationErrorException;
use app\models\forms\AdminGetOneForm;
use app\models\forms\AdminSignInForm;
use domain\entities\admin\exceptions\AdminNotFoundException;
use domain\entities\admin\exceptions\AdminNotValidException;
use domain\scenarios\admin\getOne\GetOneAdminResponse;
use domain\scenarios\admin\getOne\GetOneAdminScenario;
use domain\scenarios\admin\signIn\SignInAdminResponse;
use domain\scenarios\admin\signIn\SignInAdminScenario;
use domain\scenarios\admin\signOut\SignOutAdminRequest;
use domain\scenarios\admin\signOut\SignOutAdminResponse;
use domain\scenarios\admin\signOut\SignOutAdminScenario;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\di\NotInstantiableException;
use yii\helpers\ArrayHelper;
use yii\web\UnauthorizedHttpException;

/**
 * Class AuthController
 * @package app\controllers
 */
class AuthController extends BaseRestController
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['optional'] = ['sign-in', 'options'];

        return $behaviors;
    }

    /**
     * @return array|string[]
     */
    public function verbs(): array
    {
        return ArrayHelper::merge(parent::verbs(), [
            'sign-in' => ['POST'],
            'sign-out' => ['DELETE'],
            'get-profile' => ['GET'],
        ]);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/auth",
     *      summary="Аутентификация",
     *      operationId="signIn",
     *      tags={"sign-in"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/AdminSignInForm")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Положительный ответ на запрос",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(
     *                      property="data",
     *                      ref="#/components/schemas/SignInAdminResponse"
     *                  ),
     *                  @OA\Property(
     *                      property="error",
     *                      type="bool"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(response=400, description="Неверный логин/пароль при авторизации"),
     *      @OA\Response(response=404, description="Администратор не найден")
     *  )
     *
     * @return SignInAdminResponse
     * @throws AdminNotValidException
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     * @throws ValidationErrorException
     * @throws Throwable
     */
    public function actionSignIn(): SignInAdminResponse
    {
        $formModel = new AdminSignInForm(Yii::$app->request->getBodyParams());

        if ($formModel->validate() === false) {
            throw new ValidationErrorException($formModel->errors);
        }
        $scenario = Yii::$container->get(SignInAdminScenario::class);

        try {
            $response = $scenario->execute($formModel->getRequest());
        } catch (AdminNotFoundException $exception) {
            throw new UnauthorizedHttpException();
        }

        return $response;
    }

    /**
     * @OA\Delete (
     *      path="/api/v1/auth",
     *      summary="Выход пользователя",
     *      operationId="signOut",
     *      tags={"sign-out"},
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
     *                      ref="#/components/schemas/SignOutAdminResponse"
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
     *
     * )
     *
     * @return SignOutAdminResponse|null
     * @throws AdminNotValidException
     * @throws AdminNotValidException
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     * @throws Throwable
     */
    public function actionSignOut(): ?SignOutAdminResponse
    {
        $request = new SignOutAdminRequest();
        $request->id = Yii::$app->user->id;

        $scenario = Yii::$container->get(SignOutAdminScenario::class);

        return $scenario->execute($request);
    }

    /**
     * @OA\Get (
     *      path="/api/v1/auth",
     *      summary="Получение информации о текущем пользователе",
     *      operationId="getProfile",
     *      tags={"profile"},
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
     * @return array|GetOneAdminResponse
     * @return GetOneAdminResponse
     * @throws AdminNotFoundException
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     * @throws ValidationErrorException
     */
    public function actionGetProfile(): GetOneAdminResponse
    {
        $formModel = new AdminGetOneForm();
        $formModel->id = Yii::$app->user->id;

        if ($formModel->validate() === false) {
            throw new ValidationErrorException($formModel->errors);
        }

        $scenario = Yii::$container->get(GetOneAdminScenario::class);

        return $scenario->execute($formModel->getRequest());
    }
}