<?php

namespace Orchestra\Canvas\Console;

use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:factory', description: 'Create a new model factory')]
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
