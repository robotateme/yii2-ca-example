<?php

$bootstrap = [];

if(YII_ENV_DEV) {
    $bootstrap[] = 'debug';
    $bootstrap[] = 'gii';
}

return $bootstrap;