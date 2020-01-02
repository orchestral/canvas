<?php

namespace Orchestra\Canvas\Commands\Routing;

use Orchestra\Canvas\Commands\Generator;

class Middleware extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:middleware';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new middleware class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Middleware';

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return __DIR__.'/../../../storage/routing/middleware.stub';
    }

    /**
     * Get the default namespace for the class.
     */
    protected function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Http\Middleware';
    }
}
