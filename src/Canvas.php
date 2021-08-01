<?php

namespace Orchestra\Canvas;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;

class Canvas
{
    /**
     * Make Preset from configuration.
     *
     * @return \Orchestra\Canvas\Core\Presets\Preset
     */
    public static function preset(array $config, string $basePath, Filesystem $files): Core\Presets\Preset
    {
        $configuration = Arr::except($config, 'preset');

        switch ($config['preset']) {
            case 'package':
                return new Core\Presets\Package($configuration, $basePath, $files);
            case 'laravel':
                return new Core\Presets\Laravel($configuration, $basePath, $files);
            default:
                if (class_exists($config['preset'])) {
                    return new $config['preset']($configuration, $basePath, $files);
                }

                return new Core\Presets\Laravel($configuration, $basePath, $files);
        }
    }
}
