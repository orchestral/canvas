<?php

namespace Orchestra\Canvas\Processors;

use Illuminate\Support\Str;
use Orchestra\Canvas\Core\GeneratesCode;

/**
 * @property \Orchestra\Canvas\Commands\Listener $listener
 *
 * @see https://github.com/laravel/framework/blob/8.x/src/Illuminate/Foundation/Console/ListenerMakeCommand.php
 */
class GeneratesListenerCode extends GeneratesCode
{
    /**
     * Build the class with the given name.
     */
    protected function buildClass(string $name): string
    {
        $event = $this->options['event'];

        if (\is_null($event) || ! Str::startsWith($event, [
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
     */
    protected function alreadyExists(string $rawName): bool
    {
        return class_exists($rawName);
    }
}
