<?php

namespace Orchestra\Canvas\Presets;

use Illuminate\Support\Arr;
use InvalidArgumentException;
use Symfony\Component\Console\Application;

class Package extends Preset
{
    /**
     * List of global generators.
     *
     * @var array<int, class-string<\Symfony\Component\Console\Command\Command>>
     */
    protected static $generators = [];

    /**
     * Add global command.
     *
     * @param  array<int, class-string<\Symfony\Component\Console\Command\Command>>  $generators
     */
    public static function commands(array $generators): void
    {
        static::$generators = array_merge(static::$generators, $generators);
    }

    /**
     * Preset name.
     */
    public function name(): string
    {
        return 'package';
    }

    /**
     * Get the path to the source directory.
     */
    public function sourcePath(): string
    {
        return sprintf(
            '%s/%s',
            $this->basePath(),
            $this->config('paths.src', 'src')
        );
    }

    /**
     * Preset namespace.
     */
    public function rootNamespace(): string
    {
        $namespace = trim($this->config['namespace'] ?? '');

        if (empty($namespace)) {
            throw new InvalidArgumentException("Please configure namespace configuration under 'canvas.yaml'");
        }

        return $namespace;
    }

    /**
     * Command namespace.
     *
     * @return string
     */
    public function commandNamespace(): string
    {
        return $this->config('console.namespace', $this->rootNamespace().'\Console');
    }

    /**
     * Model namespace.
     */
    public function modelNamespace(): string
    {
        return $this->config('model.namespace', $this->rootNamespace());
    }

    /**
     * Provider namespace.
     */
    public function providerNamespace(): string
    {
        return $this->config('provider.namespace', $this->rootNamespace());
    }

    /**
     * Testing namespace.
     */
    public function testingNamespace(): string
    {
        return $this->config('testing.namespace', $this->rootNamespace().'\Tests');
    }

    /**
     * Get custom stub path.
     */
    public function getCustomStubPath(): ?string
    {
        return null;
    }

    /**
     * Sync commands to preset.
     */
    public function addAdditionalCommands(Application $app): void
    {
        parent::addAdditionalCommands($app);

        foreach (Arr::wrap(static::$generators) as $generator) {
            /** @var class-string<\Symfony\Component\Console\Command\Command> $generator */
            $app->add(new $generator($this));
        }
    }
}
