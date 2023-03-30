<?php

namespace core\helpers;

use ErrorException;

/**
 * Вспомагательный класс для управления настройками приложения.
 *
 * Class Configurator
 * @package config
 */
class Configurator
{
    /** @var string */
    public string $configPath = __DIR__;

    /**
     * Дирректория с настройками, которые сохраняются в репо.
     * Чаще всего содержит тестовые настройки.
     * @var string
     */
    public string $frameDir = 'frame';

    /**
     * Дирректория для локальных настроект.
     * Перекрывает содержимое `frameDir`.
     * @var string
     */
    public string $localDir = 'local';

    /**
     * Массив исключений, полученных в ходе сборки конфига.
     * @var ErrorException[]
     */
    private array $exceptions = [];

    /**
     * Configurator constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Подключает конфигурационный файл.
     * Если есть файл в `localDir` - будет подключен он. Если локального нет - будет подключен файл из `frameDir`.
     *
     * @param string $shortPath
     * @return string|array|null
     */
    public function requireConfig(string $shortPath)
    {
        $cfg = $this;

        $localPath = $this->getPath($shortPath, $this->localDir);
        $framePath = $this->getPath($shortPath, $this->frameDir);

        if (file_exists($localPath)) {
            return require $localPath;
        }

        if (file_exists($framePath)) {
            return require $framePath;
        }

        $this->exceptions[] = new \ErrorException("Wrong config short path: '$shortPath'");

        return null;
    }

    /**
     * @return bool
     */
    public function hasExceptions(): bool
    {
        return !empty($this->exceptions);
    }

    /**
     * @param string $delimiter
     */
    public function printExceptions(string $delimiter = '<br>'): void
    {
        if (YII_DEBUG) {
            foreach ($this->exceptions as $i => $e) {
                $trace = $e->getTrace();
                $configError = $trace[count($trace) - 2] ?? $trace[0];
                echo sprintf('%s) %s in %s at %s line', $i + 1, $e->getMessage(), $configError['file'], $configError['line']) . $delimiter;
            }
        } else {
            echo 'Configuration Error. Please, contact the administrator.';
        }
    }

    /**
     * @param string $shortPath
     * @param ?string $section
     * @return string
     */
    private function getPath(string $shortPath, ?string $section = null): string
    {
        $path = $this->configPath . DIRECTORY_SEPARATOR;

        if ($section) {
            $path .= ($section . DIRECTORY_SEPARATOR);
        }

        $path .= $shortPath;

        $path = str_replace(array('//', '/\\', '\\/'), '/', $path);

        return $path;
    }
}
