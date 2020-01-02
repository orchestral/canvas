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
            $this->config['src'] ?? 'src'
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
}
