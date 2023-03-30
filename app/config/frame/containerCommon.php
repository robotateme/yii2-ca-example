<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(
    $cfg->requireConfig('container/common.php'),
    $cfg->requireConfig('container/admin.php')
);