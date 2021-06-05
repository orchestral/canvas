<?php

namespace Orchestra\Canvas\Processors;

use Orchestra\Canvas\Core\GeneratesCode;

class GeneratesExceptionCode extends GeneratesCode
{
    /**
     * Determine if the class already exists.
     *
     * @todo need to be replaced
     */
    protected function alreadyExists(string $rawName): bool
    {
        return class_exists($this->getDefaultNamespace($this->rootNamespace()).'\\'.$rawName);
    }
}
