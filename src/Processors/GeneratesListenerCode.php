<?php

namespace Orchestra\Canvas\Processors;

use Illuminate\Support\Str;
use Orchestra\Canvas\Core\GeneratesCode;

class GeneratesListenerCode extends GeneratesCode
{
    /**
     * Build the class with the given name.
     *
     * @todo
     */
    protected function buildClass(string $name): string
    {
        $event = $this->options['event'];

        if (! Str::startsWith($event, [
            $this->preset->rootNamespace(),
            'Illuminate',
            '\\',
        ])) {
            $event = $this->preset->rootNamespace().'\\Events\\'.$event;
        }

        $stub = str_replace(
            'DummyEvent', class_basename($event), parent::buildClass($name)
        );

        return str_replace(
            'DummyFullEvent', trim($event, '\\'), $stub
        );
    }

    /**
     * Determine if the class already exists.
     *
     * @todo
     */
    protected function alreadyExists(string $rawName): bool
    {
        return class_exists($rawName);
    }
}
