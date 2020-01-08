<?php

namespace Orchestra\Canvas\Processors;

use Illuminate\Support\Str;

class GeneratesCodeWithComponent extends GeneratesCode
{
    /**
     * Build the class with the given name.
     */
    protected function buildClass(string $name): string
    {
        $class = parent::buildClass($name);

        if (! empty($this->options['view'])) {
            $class = \str_replace(
                'DummyView',
                'components.'.Str::kebab(\class_basename($name)),
                $class
            );
        }

        return $class;
    }
}
