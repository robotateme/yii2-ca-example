<?php

namespace app\components\authManager;

use http\Exception\InvalidArgumentException;
use Yii;
use yii\base\Exception;
use yii\rbac\PhpManager;

class RbacGenerator
{
    /** @var string */
    public string $itemsFileAlias = '@app/rbac/items.php';

    /** @var string */
    public string $rulesFileAlias = '@app/rbac/rules.php';

    /** @var string */
    public string $configFileAlias = '@app/config/rbac.php';

    /** @var array */
    private array $config = [];

    /** @var PhpManager */
    private PhpManager $authManager;

    /**
     * @param PhpManager|null $authManager
     * @param string|null $configFileAlias
     * @param string|null $itemsFileAlias
     * @param string|null $rulesFileAlias
     */
    public function __construct(?PhpManager $authManager = null, ?string $configFileAlias = null, ?string $itemsFileAlias = null, ?string $rulesFileAlias = null)
    {
        $this->configFileAlias = $configFileAlias ?? $this->configFileAlias;
        $this->itemsFileAlias = $itemsFileAlias ?? $this->itemsFileAlias;
        $this->rulesFileAlias = $rulesFileAlias ?? $this->rulesFileAlias;
        $this->authManager = $authManager ?? Yii::$app->authManager;

        $this->requireConfig();
    }

    /**
     * @return void
     */
    private function requireConfig(): void
    {
        $configFile = Yii::getAlias($this->configFileAlias);
        if (file_exists($configFile) === false) {
            throw new InvalidArgumentException(sprintf('Config file "%s" not found.', $configFile));
        }

        $this->config = require $configFile;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function init(): void
    {
        $this->removeItems();
        $this->removeRules();

        $this->authManager->removeAll();

        $rule = new RbacCommonRule();
        $this->authManager->add($rule);

        $roles = [];
        foreach ($this->config['roles'] as $role) {
            $roles[$role] = $this->authManager->createRole($role);
            $roles[$role]->ruleName = $rule->name;
            $this->authManager->add($roles[$role]);
        }

        foreach ($this->config['permissions'] as $controllerName => $actions) {
            foreach ($actions as $actionName => $actionRoles) {
                $permission = $this->authManager->createPermission(sprintf('%s::%s', $controllerName, $actionName));
                $this->authManager->add($permission);

                foreach ($actionRoles as $role) {
                    $this->authManager->addChild($roles[$role], $permission);
                }
            }
        }
    }

    /**
     * @return void
     */
    private function removeItems(): void
    {
        $itemsFile = Yii::getAlias($this->itemsFileAlias);
        if (file_exists($itemsFile) === true) {
            unlink($itemsFile);
        }
    }

    /**
     * @return void
     */
    private function removeRules(): void
    {
        $rulesFile = Yii::getAlias($this->rulesFileAlias);
        if (file_exists($rulesFile) === true) {
            unlink($rulesFile);
        }
    }
}