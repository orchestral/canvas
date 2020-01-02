<?php

namespace Laravie\Canvas\Presets;

use Illuminate\Filesystem\Filesystem;
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
     * Get configuration.
     *
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    public function config(?string $key = null, $default = null)
    {
        if (\is_null($key)) {
            return $this->config;
        }

        return Arr::get($this->config, $key, $default);
    }

    /**
     * Get the filesystem instance.
     */
    public function filesystem(): Filesystem
    {
        return $this->files;
    }

    /**
     * Get the path to the base working directory.
     */
    public function basePath(): string
    {
        return $this->basePath;
    }

    /**
     * Get the path to the factory directory.
     */
    public function factoryPath(): string
    {
        return \sprintf(
            '%s/%s',
            $this->basePath(),
            $this->config['factory']['path'] ?? 'database/factories'
        );
    }

    /**
     * Get the path to the migration directory.
     */
    public function migrationPath(): string
    {
        return \sprintf(
            '%s/%s',
            $this->basePath(),
            $this->config['migration']['path'] ?? 'database/migrations'
        );
    }

    /**
     * Preset name.
     */
    abstract public function name(): string;

    /**
     * Get the path to the source directory.
     */
    abstract public function sourcePath(): string;

    /**
     * Get the path to the resource directory.
     */
    abstract public function resourcePath(): string;

    /**
     * Preset namespace.
     */
    abstract public function rootNamespace(): string;

    /**
     * Provider namespace.
     */
    abstract public function providerNamespace(): string;
}
