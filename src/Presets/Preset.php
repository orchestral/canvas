<?php

namespace Laravie\Canvas\Presets;

use Illuminate\Support\Arr;

abstract class Preset
{
    /**
     * Preset configuration.
     *
     * @var array
     */
    protected $config;

    /**
     * Preset base path.
     *
     * @var string
     */
    protected $basePath;

    /**
     * Construct a new preset.
     */
    public function __construct(array $config, string $basePath)
    {
        $this->config = $config;
        $this->basePath = $basePath;
    }

    /**
     * Make Preset from configuration.
     *
     * @return static
     */
    public static function make(array $config, string $basePath)
    {
        $configuration = Arr::except($config, 'preset');

        switch ($config['preset']) {
            case 'package':
                return new Package($configuration, $basePath);
            case 'laravel':
                return new Laravel($configuration, $basePath);
            default:
                if (\class_exists($config['preset'])) {
                    return new $config['preset']($configuration, $basePath);
                }

                return new Laravel($configuration, $basePath);
        }
    }

    /**
     * Get the path to the base working directory.
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * Get the path to the migration directory.
     */
    public function getMigrationPath(): string;
    {
        return \sprintf('%s/database/migrations', $this->getBasePath());
    }

    /**
     * Preset name.
     */
    abstract public function getName(): string;
}
