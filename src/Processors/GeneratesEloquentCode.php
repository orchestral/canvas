<?php

namespace Orchestra\Canvas\Processors;

class GeneratesEloquentCode extends GeneratesCode
{
    /**
     * Get the root namespace for the class.
     */
    protected function rootNamespace(): string
    {
        return $this->preset->modelNamespace();
    }
}
