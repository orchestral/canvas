<?php

namespace Orchestra\Canvas\Commands;

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
     * Build the class with the given name.
     */
    protected function buildClass(string $name): string
    {
        return \str_replace(
            'DummyUser',
            \class_basename($this->userProviderModel()),
            parent::buildClass($name)
        );
    }

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return  __DIR__.'/../../../storage/laravel/channel.stub';
    }

    /**
     * Get the default namespace for the class.
     */
    protected function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Broadcasting';
    }
}
