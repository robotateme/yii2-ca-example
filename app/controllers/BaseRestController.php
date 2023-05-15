<?php

namespace app\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Test Admin panel",
 *         description="Admin REST API documentation",
 *         termsOfService="http://swagger.io/terms/",
 *         @OA\Contact(
 *             email="administarator@test.loc"
 *         ),
 *     ),
 *     @OA\Server(
 *         description="OpenApi host",
 *         url="http://admin.test.loc"
 *     ),
 *     security={{"bearerAuth": {}}},
 *     @OA\Tag(
 *         name="EndPoints"
 *     )
 * )
 * @OA\Components(
 *      @OA\SecurityScheme(
 *          securityScheme="bearerAuth",
 *          type="http",
 *          scheme="bearer",
 *      ),
 *      @OA\Attachable
 * )
*/
abstract class BaseRestController extends Controller
{

    /** @var bool */
    public $enableCsrfValidation = false;

    /**
     * @return array
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        return $behaviors;
    }

    /**
     * @return string[][]
     */
    public function verbs(): array
    {
        return [
            'options' => ['OPTIONS'],
        ];
    }

    /**
     * @return void
     */
    public function actionOptions()
    {
        if (Yii::$app->getRequest()->getMethod() !== 'OPTIONS') {
            Yii::$app->getResponse()->setStatusCode(405);
        }

        $result = [];
        foreach ($this->verbs() as $verbs) {
            if (is_array($verbs) === false) {
                $verbs = [$verbs];
            }

            foreach ($verbs as $verb) {
                $result[] = $verb;
            }
        }

        Yii::$app->getResponse()->getHeaders()->set('Allow', implode(', ', array_unique($result)));
    }
}