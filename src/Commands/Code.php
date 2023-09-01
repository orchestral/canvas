<?php

namespace Orchestra\Canvas\Commands;

use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:class', description: 'Create a new class')]
class Code extends Generator
{
    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected string $type = 'Class';

    /**
     * Get the stub file for the generator.
     */
    public function getStubFile(): string
    {
        return $this->getStubFileName();
    }

    /**
     * Get the stub file name for the generator.
     */
    public function getStubFileName(): string
    {
        return __DIR__.'/../../storage/canvas/code.stub';
    }
}
