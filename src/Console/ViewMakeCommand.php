<?php

namespace Orchestra\Canvas\Console;

use Orchestra\Canvas\GeneratorPreset;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:view', description: 'Create a new view')]
class ViewMakeCommand extends \Illuminate\Foundation\Console\ViewMakeCommand
{
    /**
     * Resolve the default fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveDefaultStubPath($stub)
    {
        $preset = $this->generatorPreset();

        if ($preset instanceof GeneratorPreset) {
            return __DIR__.$stub;
        }

        return parent::resolveDefaultStubPath($stub);
    }
}
