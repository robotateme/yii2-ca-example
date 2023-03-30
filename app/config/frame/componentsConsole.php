<?php

return array_merge(
    $cfg->requireConfig('componentsCommon.php'),
    [
        'db' => $cfg->requireConfig('components/dbConsole.php'),
    ]
);