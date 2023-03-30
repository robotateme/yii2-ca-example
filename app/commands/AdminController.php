<?php

namespace app\commands;

use domain\entities\admin\dictionaries\AdminRolesDictionary;
use domain\entities\admin\exceptions\AdminNotValidException;
use domain\scenarios\admin\create\CreateAdminRequest;
use domain\scenarios\admin\create\CreateAdminScenario;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\console\Controller;
use yii\di\NotInstantiableException;

class AdminController extends Controller
{
    /**
     * @param string $login
     * @param string $email
     * @param string $password
     * @return void
     * @throws Throwable
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    public function actionCreateSuperAdmin(string $login, string $email, string $password): void
    {
        $scenario = Yii::$container->get(CreateAdminScenario::class);

        $request = new CreateAdminRequest();
        $request->login = $login;
        $request->email = $email;
        $request->password = $password;
        $request->role = AdminRolesDictionary::SUPER_ADMIN;
        $request->firstName = 'Super';
        $request->lastName = 'Admin';
        $request->middleName = 'Main';

        try {
            $response = $scenario->execute($request);
        } catch (AdminNotValidException $exception) {
            var_dump($exception->getErrors()); die;
        }
        $this->stdout('Super admin successfully created!' . PHP_EOL);
    }
}