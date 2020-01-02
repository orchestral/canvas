<?php

namespace Laravie\Canvas\Commands;

class Event extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new event class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Event';

    /**
     * Determine if the class already exists.
     *
     * @param  string  $rawName
     *
     * @return bool
     */
    protected function alreadyExists(string $rawName): bool
    {
        return \class_exists($rawName);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__.'/../../storage/event/event.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Events';
    }
}
