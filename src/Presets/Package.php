<?php

namespace Laravie\Canvas\Presets;

class Package extends Preset
{
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
        return \sprintf(
            '%s/%s',
            $this->basePath(),
            $this->config('paths.src', 'src')
        );
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
     * Preset namespace.
     */
    public function rootNamespace(): string
    {
        $namespace = $this->config['namespace'] ?? null;

        if (\is_null($namespace)) {
            throw new InvalidArgumentException('Please configure namespace configuration under canvas.yaml');
        }

        return $namespace;
    }

    /**
     * Provider namespace.
     */
    public function providerNamespace(): string
    {
        return $this->config('provider.namespace', $this->rootNamespace());
    }
}
