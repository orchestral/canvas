<?php

namespace Orchestra\Canvas;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;

class Canvas
{
    /**
     * Make Preset from configuration.
     *
     * @param  array<string, mixed>  $config
     *
     * @return \Orchestra\Canvas\Core\Presets\Preset
     */
    public static function preset(array $config, string $basePath, Filesystem $files): Core\Presets\Preset
    {
        /** @var array<string, mixed> $configuration */
        $configuration = Arr::except($config, 'preset');

        $preset = $config['preset'];

        switch ($preset) {
            case 'package':
                return new Core\Presets\Package($configuration, $basePath, $files);
            case 'laravel':
                return new Core\Presets\Laravel($configuration, $basePath, $files);
            default:
                if (class_exists($preset)) {
                    /** @var class-string<\Orchestra\Canvas\Core\Presets\Preset> $preset */
                    return new $preset($configuration, $basePath, $files);
                }

                return new Core\Presets\Laravel($configuration, $basePath, $files);
        }
    }
}
