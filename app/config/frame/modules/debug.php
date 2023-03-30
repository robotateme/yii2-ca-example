<?php
return [
    'class' => yii\debug\Module::class,
    'traceLine' => function ($options, $panel) use ($cfg) {
        $homeDir = $cfg->requireConfig('homedDir.php');
        $filePath = str_replace(Yii::$app->basePath, $homeDir, $options['file']);

        return strtr('<a href="phpstorm://open/?file={file}&line={line}">{file}:{line}</a>', ['{file}' => $filePath]);
    },
    'allowedIPs' => ['10.0.2.*', '127.0.0.1', '::1'],
];
