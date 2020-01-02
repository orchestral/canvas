<?php

namespace Laravie\Canvas\Presets;

class Laravel extends Preset
{
    /**
     * Preset name.
     */
    public function name(): string
    {
        return 'laravel';
    }

    /**
     * Get the path to the source directory.
     */
    public function sourcePath(): string
    {
        return \sprintf(
            '%s/%s',
            $this->basePath(),
            $this->config('paths.src', 'app')
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
        return $this->config['namespace'] ?? 'App';
    }

    /**
     * Provider namespace.
     */
    public function providerNamespace(): string
    {
        return $this->config('provider.namespace', $this->rootNamespace().'\Providers');
    }
}
