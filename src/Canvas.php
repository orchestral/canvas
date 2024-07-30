<?php

namespace Orchestra\Canvas;

use Illuminate\Support\Arr;

class Canvas
{
    /**
     * Make Preset from configuration.
     *
     * @param  array<string, mixed>  $config
     */
    public static function preset(array $config, string $basePath): Presets\Preset
    {
        /** @var array<string, mixed> $configuration */
        $configuration = Arr::except($config, 'preset');

        $preset = $config['preset'];

        $resolveDefaultPreset = function ($configuration, $basePath) use ($preset) {
            if (class_exists($preset)) {
                /**
                 * @var class-string<\Orchestra\Canvas\Presets\Preset> $preset
                 *
                 * @return \Orchestra\Canvas\Presets\Preset
                 */
                return new $preset($configuration, $basePath);
            }

            return new Presets\Laravel($configuration, $basePath);
        };

        return match ($preset) {
            'package' => new Presets\Package($configuration, $basePath),
            'laravel' => new Presets\Laravel($configuration, $basePath),
            default => $resolveDefaultPreset($configuration, $basePath),
        };
    }
}
