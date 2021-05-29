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

        if (! empty($this->options['markdown'])) {
            $class = str_replace('DummyView', $this->options['markdown'], $class);
        }

        return $class;
    }
}
