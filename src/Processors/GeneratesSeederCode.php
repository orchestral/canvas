<?php

namespace Orchestra\Canvas\Processors;

class GeneratesSeederCode extends GeneratesCode
{
    /**
     * Get the destination class path.
     */
    protected function getPath(string $name): string
    {
        return $this->preset->seederPath().'/'.$name.'.php';
    }

    /**
     * Parse the class name and format according to the root namespace.
     */
    protected function qualifyClass(string $name): string
    {
        return $name;
    }
}
