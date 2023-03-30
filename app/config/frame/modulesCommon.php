<?php

$modules = [];

if (YII_ENV_DEV) {
    $modules['debug'] = $cfg->requireConfig('modules/debug.php');
    $modules['gii'] = $cfg->requireConfig('modules/gii.php');
}

return $modules;