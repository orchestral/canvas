<?php

namespace Orchestra\Canvas\Processors;

class GeneratesEventCode extends GeneratesCode
{
    /**
     * Determine if the class already exists.
     */
    protected function alreadyExists(string $rawName): bool
    {
        return \class_exists($rawName);
    }
}
