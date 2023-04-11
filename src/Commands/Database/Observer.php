<?php

namespace Orchestra\Canvas\Commands\Database;

use Orchestra\Canvas\Commands\Generator;
use Orchestra\Canvas\Processors\GeneratesObserverCode;
use Symfony\Component\Console\Input\InputOption;

/**
 * @see https://github.com/laravel/framework/blob/10.x/src/Illuminate/Foundation/Console/ObserverMakeCommand.php
 */
#[\Symfony\Component\Console\Attribute\AsCommand(name: 'make:observer')]
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
    protected string $type = 'Observer';

    /**
     * Generator processor.
     *
     * @var string
     */
    protected $processor = GeneratesObserverCode::class;

    /**
     * Get the stub file for the generator.
     */
    public function getStubFile(): string
    {
        return $this->getStubFileFromPresetStorage($this->preset, $this->getStubFileName());
    }

    /**
     * Get the stub file name for the generator.
     */
    public function getStubFileName(): string
    {
        return $this->option('model')
            ? 'observer.stub'
            : 'observer.plain.stub';
    }

    /**
     * Get the default namespace for the class.
     */
    public function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Observers';
    }

    /**
     * Generator options.
     *
     * @return array<string, mixed>
     */
    public function generatorOptions(): array
    {
        return [
            'model' => $this->option('model'),
            'force' => $this->option('force'),
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array<int, array>
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the observer already exists'],
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the observer applies to.'],
        ];
    }
}
