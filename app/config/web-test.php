<?php

use core\helpers\Configurator;

$cfg = new Configurator(['configPath' => __DIR__]);

$config = [
    'id' => 'web-test-app',
    'defaultRoute' => 'default/dashboard',
    'language' => 'en-US',
    'layout' => 'inner-page',
    'basePath' => dirname(__DIR__),
    'vendorPath' => __DIR__ . '/../../vendor',
    'aliases' => $cfg->requireConfig('aliases.php'),
    'homeUrl' => $cfg->requireConfig('homeUrl.php'),
    'version' => $cfg->requireConfig('version.php'),
    'params' => $cfg->requireConfig('params.php'),
    'container' => $cfg->requireConfig('containerWeb.php'),
    'bootstrap' => $cfg->requireConfig('bootstrapWeb.php'),
    'components' => $cfg->requireConfig('componentsWeb.php'),
    'modules' => $cfg->requireConfig('modulesWeb.php'),
];

if ($cfg->hasExceptions()) {
    $cfg->printExceptions();
    die;
}

return $config;