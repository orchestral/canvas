<?php

namespace Orchestra\Canvas\Console;

class FactoryMakeCommand extends \Illuminate\Database\Console\Factories\FactoryMakeCommand
{
    /**
     * Resolve the default fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveDefaultStubPath($stub)
    {
        return __DIR__.$stub;
    }
}
