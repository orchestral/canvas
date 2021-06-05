<?php

namespace Orchestra\Canvas\Processors;

use Orchestra\Canvas\Core\GeneratesCode;

class GeneratesEventCode extends GeneratesCode
{
    /**
     * Determine if the class already exists.
     */
    protected function alreadyExists(string $rawName): bool
    {
        return class_exists($rawName);
    }
}
