<?php

namespace Orchestra\Canvas\Processors;

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Str;
use Orchestra\Canvas\Core\GeneratesCode;

class GeneratesCodeWithComponent extends GeneratesCode
{
    /**
     * Build the class with the given name.
     */
    protected function buildClass(string $name): string
    {
        $class = parent::buildClass($name);

        if (! empty($this->options['inline'])) {
            $class = str_replace(
                'DummyView',
                "<<<'blade'\n<div>\n    ".Inspiring::quote()."\n</div>\nblade",
                $class
            );
        }

        return str_replace(
            'DummyView',
            'view(\'components.'.Str::kebab(class_basename($name)).'\')',
            $class
        );
    }
}
