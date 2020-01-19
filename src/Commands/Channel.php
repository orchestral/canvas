<?php

namespace Orchestra\Canvas\Commands;

use Orchestra\Canvas\Core\Commands\Generator;

class Channel extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:channel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new channel class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Channel';

    /**
     * Get the stub file for the generator.
     */
    public function getStubFile(): string
    {
        return __DIR__.'/../../storage/laravel/channel.stub';
    }

    /**
     * Get the default namespace for the class.
     */
    public function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Broadcasting';
    }
}
