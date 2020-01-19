<?php

namespace Orchestra\Canvas\Core\Presets;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Symfony\Component\Console\Application;

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
     * Check if preset name equal to $name.
     */
    public function is(string $name): bool
    {
        return $this->name() === $name;
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
     * Get the path to the resource directory.
     */
    public function resourcePath(): string
    {
        return \sprintf(
            '%s/%s',
            $this->basePath(),
            $this->config('paths.resource', 'resources')
        );
    }

    /**
     * Get the path to the factory directory.
     */
    public function factoryPath(): string
    {
        return \sprintf(
            '%s/%s',
            $this->basePath(),
            $this->config('factory.path', 'database/factories')
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
            $this->config('migration.path', 'database/migrations')
        );
    }

    /**
     * Get the path to the seeder directory.
     */
    public function seederPath(): string
    {
        return \sprintf(
            '%s/%s',
            $this->basePath(),
            $this->config('seeder.path', 'database/seeds')
        );
    }

    /**
     * Sync commands to preset.
     */
    public function addAdditionalCommands(Application $app): void
    {
        foreach ($this->config('generators', []) as $generator) {
            $app->add(new $generator($this));
        }
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
     * Preset namespace.
     */
    abstract public function rootNamespace(): string;

    /**
     * Model namespace.
     */
    abstract public function modelNamespace(): string;

    /**
     * Provider namespace.
     */
    abstract public function providerNamespace(): string;
}
