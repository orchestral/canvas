<?php

namespace Orchestra\Canvas\Processors;

use Orchestra\Canvas\Core\GeneratesCode;

class GeneratesCodeWithMarkdown extends GeneratesCode
{
    /**
     * Replace the namespace for the given stub.
     */
    protected function replaceNamespace(string $stub, string $name): string
    {
        $stub = parent::replaceNamespace($stub, $name);

        if (! empty($this->options['view'])) {
            $stub = str_replace(['DummyView', '{{ view }}', '{{view}}'], $this->options['view'], $stub);
        }

        return $stub;
    }
}
