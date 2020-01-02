<?php

namespace Laravie\Canvas;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;

class Canvas
{
    /**
     * Make Preset from configuration.
     *
     * @return \Laravie\Canvas\Presets\Preset
     */
    public static function preset(array $config, string $basePath, Filesystem $files): Presets\Preset
    {
        $configuration = Arr::except($config, 'preset');

        switch ($config['preset']) {
            case 'package':
                return new Presets\Package($configuration, $basePath, $files);
            case 'laravel':
                return new Presets\Laravel($configuration, $basePath, $files);
            default:
                if (\class_exists($config['preset'])) {
                    return new $config['preset']($configuration, $basePath, $files);
                }

                return new Presets\Laravel($configuration, $basePath, $files);
        }
    }
}
