<?php

namespace Orchestra\Canvas;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Canvas
{
    /**
     * Assume the preset from environment.
     */
    public static function presetFromEnvironment(string $basePath): string
    {
        /** detect `testbench.yaml` */
        $testbenchYaml = Collection::make([
            'testbench.yaml',
            'testbench.yaml.example',
            'testbench.yaml.dist',
        ])->filter(fn ($filename) => file_exists($basePath.DIRECTORY_SEPARATOR.$filename))
            ->first();

        if (! \is_null($testbenchYaml)) {
            return 'package';
        }

        return Collection::make([
            file_exists($basePath.DIRECTORY_SEPARATOR.'artisan'),
            file_exists($basePath.DIRECTORY_SEPARATOR.'bootstrap'.DIRECTORY_SEPARATOR.'app.php'),
            is_dir($basePath.DIRECTORY_SEPARATOR.'bootstrap'.DIRECTORY_SEPARATOR.'cache'),
        ])->reject(fn ($condition) => $condition === true)
            ->isEmpty() ? 'laravel' : 'package';
    }

    /**
     * Make Preset from configuration.
     *
     * @param  array<string, mixed>  $config
     * @return \Orchestra\Canvas\Presets\Preset
     */
    public static function preset(array $config, string $basePath): Presets\Preset
    {
        /** @var array<string, mixed> $configuration */
        $configuration = Arr::except($config, 'preset');

        $preset = $config['preset'];

        switch ($preset) {
            case 'package':
                return new Presets\Package($configuration, $basePath);
            case 'laravel':
                return new Presets\Laravel($configuration, $basePath);
            default:
                if (class_exists($preset)) {
                    /**
                     * @var class-string<\Orchestra\Canvas\Presets\Preset> $preset
                     *
                     * @return \Orchestra\Canvas\Presets\Preset
                     */
                    return new $preset($configuration, $basePath);
                }

                return new Presets\Laravel($configuration, $basePath);
        }
    }
}
