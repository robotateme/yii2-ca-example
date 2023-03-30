<?php

return array_merge(
    $cfg->requireConfig('componentsCommon.php'),
    [
        'db' => $cfg->requireConfig('components/dbWeb.php'),
        'dbGrandPay' => $cfg->requireConfig('components/dbGrandPay.php'),
        'request' => $cfg->requireConfig('components/request.php'),
        'urlManager' => $cfg->requireConfig('components/urlManager.php'),
        'user' => $cfg->requireConfig('components/user.php'),
        'response' => $cfg->requireConfig('components/response.php'),
    ]
);