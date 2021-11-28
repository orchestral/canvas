<?php

namespace Orchestra\Canvas\Processors;

use Orchestra\Canvas\Core\GeneratesCode;

class GeneratesCodeWithMarkdown extends GeneratesCode
{
    /**
     * Build the class with the given name.
     */
    protected function buildClass(string $name): string
    {
        $class = parent::buildClass($name);

        if (! empty($this->options['view'])) {
            $class = str_replace(['DummyView', '{{ view }}', '{{view}}'], $this->options['view'], $class);
        }

        return $class;
    }
}
