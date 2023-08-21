<?php

namespace Orchestra\Canvas\Processors;

use Orchestra\Canvas\Core\GeneratesCode;

/**
 * @property \Orchestra\Canvas\Commands\Database\Seeder $listener
 *
 * @see https://github.com/laravel/framework/blob/8.x/src/Illuminate/Database/Console/Seeds/SeederMakeCommand.php
 */
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

    /**
     * Get the root namespace for the class.
     */
    protected function rootNamespace(): string
    {
        return $this->preset->seederNamespace();
    }
}
