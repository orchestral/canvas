<?php

namespace Laravie\Canvas\Presets;

use Illuminate\Filesystem\Filesystem;

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
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Construct a new preset.
     */
    public function __construct(array $config, string $basePath, Filesystem $files)
    {
        $this->config = $config;
        $this->basePath = $basePath;
        $this->files = $files;
    }

    /**
     * Get the filesystem instance.
     */
    public function getFilesystem(): Filesystem
    {
        return $this->files;
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
    public function getMigrationPath(): string
    {
        return \sprintf('%s/database/migrations', $this->getBasePath());
    }

    /**
     * Preset name.
     */
    abstract public function getName(): string;
}
