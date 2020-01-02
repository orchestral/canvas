<?php

namespace Orchestra\Canvas\Commands\Database;

use Illuminate\Support\Str;
use Orchestra\Canvas\Commands\Generator;
use Symfony\Component\Console\Input\InputOption;

class Observer extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:observer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new observer class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Observer';

    /**
     * Build the class with the given name.
     */
    protected function buildClass(string $name): string
    {
        $stub = parent::buildClass($name);

        $model = $this->option('model');

        return $model ? $this->replaceModel($stub, $model) : $stub;
    }

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        $directory = __DIR__.'/../../../storage/database/eloquent';

        return $this->option('model')
            ? "{$directory}/observer.stub"
            : "{$directory}/observer.plain.stub";
    }

    /**
     * Replace the model for the given stub.
     */
    protected function replaceModel(string $stub, string $model): string
    {
        $model = \str_replace('/', '\\', $model);

        $namespaceModel = $this->preset->rootNamespace().'\\'.$model;

        if (Str::startsWith($model, '\\')) {
            $stub = \str_replace('NamespacedDummyModel', trim($model, '\\'), $stub);
        } else {
            $stub = \str_replace('NamespacedDummyModel', $namespaceModel, $stub);
        }

        $stub = \str_replace(
            "use {$namespaceModel};\nuse {$namespaceModel};", "use {$namespaceModel};", $stub
        );

        $model = \class_basename(\trim($model, '\\'));

        $stub = \str_replace('DocDummyModel', Str::snake($model, ' '), $stub);

        $stub = \str_replace('DummyModel', $model, $stub);

        return \str_replace('dummyModel', Str::camel($model), $stub);
    }

    /**
     * Get the default namespace for the class.
     */
    protected function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Observers';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the observer applies to.'],
        ];
    }
}
