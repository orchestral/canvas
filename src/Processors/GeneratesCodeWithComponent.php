<?php

namespace Orchestra\Canvas\Processors;

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Str;
use Orchestra\Canvas\Core\GeneratesCode;

/**
 * @property \Orchestra\Canvas\Commands\Database\Cast $listener
 *
 * @see https://github.com/laravel/framework/blob/8.x/src/Illuminate/Foundation/Console/ComponentMakeCommand.php
 */
class GeneratesCodeWithComponent extends GeneratesCode
{
    /**
     * Replace the namespace for the given stub.
     */
    protected function replaceNamespace(string $stub, string $name): string
    {
        $stub = parent::replaceNamespace($stub, $name);

        if (! empty($this->options['inline'])) {
            $stub = str_replace(
                ['DummyView', '{{ view }}', '{{view}}'],
                "<<<'blade'\n<div>\n    ".Inspiring::quote()."\n</div>\nblade",
                $stub
            );
        }

        return str_replace(
            ['DummyView', '{{ view }}', '{{view}}'],
            'view(\'components.'.Str::kebab(class_basename($name)).'\')',
            $stub
        );
    }
}
