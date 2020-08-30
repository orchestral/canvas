<?php

namespace Orchestra\Canvas\Commands\Database;

use Orchestra\Canvas\Commands\Generator;

class Cast extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:cast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new custom Eloquent cast class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Cast';

    /**
     * Get the stub file for the generator.
     */
    public function getPublishedStubFileName(): ?string
    {
        return 'cast.stub';
    }

    /**
     * Get the stub file for the generator.
     */
    public function getStubFile(): string
    {
        return $this->getStubFileFromPresetStorage($this->preset, 'cast.stub');
    }

    /**
     * Get the default namespace for the class.
     */
    public function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Casts';
    }
}
