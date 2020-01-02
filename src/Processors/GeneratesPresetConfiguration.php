<?php

namespace Orchestra\Canvas\Processors;

class GeneratesPresetConfiguration extends GeneratesCode
{
    /**
     * Get the destination class path.
     */
    protected function getPath(string $name): string
    {
        return $this->preset->basePath().'/canvas.yaml';
    }

    /**
     * Get the root namespace for the class.
     */
    protected function rootNamespace(): string
    {
        $namespace = \trim($this->options['namespace']);

        if (! empty($namespace)) {
            return $namespace;
        }

        switch ($this->getNameInput()) {
            case 'package':
                return 'PackageName';
            case 'laravel':
            default:
                return 'App';
        }
    }
}
