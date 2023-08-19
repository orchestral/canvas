<?php

namespace Orchestra\Canvas;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;

class Canvas
{
    public static function presetFromEnvironment(string $workingPath): string
    {
        /** detect `testbench.yaml` */
        $testbenchYaml = Collection::make([
            'testbench.yaml',
            'testbench.yaml.example',
            'testbench.yaml.dist',
        ])->filter(fn ($filename) => file_exists($workingPath.DIRECTORY_SEPARATOR.$workingPath))
        ->first();

        if (! \is_null($testbenchYaml)) {
            return 'package';
        }


    }

    /**
     * Make Preset from configuration.
     *
     * @param  array<string, mixed>  $config
     * @return \Orchestra\Canvas\Core\Presets\Preset
     */
    public static function preset(array $config, string $workingPath, Filesystem $files): Core\Presets\Preset
    {
        /** @var array<string, mixed> $configuration */
        $configuration = Arr::except($config, 'preset');

        $preset = $config['preset'];

        switch ($preset) {
            case 'package':
                return new Core\Presets\Package($configuration, $workingPath, $files);
            case 'laravel':
                return new Core\Presets\Laravel($configuration, $workingPath, $files);
            default:
                if (class_exists($preset)) {
                    /**
                     * @var class-string<\Orchestra\Canvas\Core\Presets\Preset> $preset
                     *
                     * @return \Orchestra\Canvas\Core\Presets\Preset
                     */
                    return new $preset($configuration, $workingPath, $files);
                }

                return new Core\Presets\Laravel($configuration, $basePath, $files);
        }
    }
}
