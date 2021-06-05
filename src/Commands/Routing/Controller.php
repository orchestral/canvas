<?php

namespace Orchestra\Canvas\Commands\Routing;

use Orchestra\Canvas\Commands\Generator;
use Orchestra\Canvas\Processors\GeneratesControllerCode;
use Symfony\Component\Console\Input\InputOption;

class Controller extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Generator processor.
     *
     * @var string
     */
    protected $processor = GeneratesControllerCode::class;

    /**
     * Get the stub file for the generator.
     */
    public function getPublishedStubFileName(): ?string
    {
        return $this->getStubFileName();
    }

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
        $stub = null;

        if ($type = $this->option('type')) {
            $stub = "controller.{$type}.stub";
        } elseif ($this->option('parent')) {
            $stub = 'controller.nested.stub';
        } elseif ($this->option('model')) {
            $stub = 'controller.model.stub';
        } elseif ($this->option('invokable')) {
            $stub = 'controller.invokable.stub';
        } elseif ($this->option('resource')) {
            $stub = 'controller.stub';
        }

        if ($this->option('api') && \is_null($stub)) {
            $stub = 'controller.api.stub';
        } elseif ($this->option('api') && ! \is_null($stub) && ! $this->option('invokable')) {
            $stub = str_replace('.stub', '.api.stub', $stub);
        }

        return $stub ?? 'controller.plain.stub';
    }

    /**
     * Get the default namespace for the class.
     */
    public function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Http\Controllers';
    }

    /**
     * Generator options.
     */
    public function generatorOptions(): array
    {
        return array_merge(parent::generatorOptions(), [
            'model' => $this->option('model'),
            'parent' => $this->option('parent'),
        ]);
    }

    /**
     * Create model.
     */
    public function createModel(string $className): void
    {
        if ($this->confirm("A {$className} model does not exist. Do you want to generate it?", true)) {
            $this->call('make:model', ['name' => $className]);
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['api', null, InputOption::VALUE_NONE, 'Exclude the create and edit methods from the controller.'],
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the controller already exists'],
            ['invokable', 'i', InputOption::VALUE_NONE, 'Generate a single method, invokable controller class.'],
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate a resource controller for the given model.'],
            ['parent', 'p', InputOption::VALUE_OPTIONAL, 'Generate a nested resource controller class.'],
            ['resource', 'r', InputOption::VALUE_NONE, 'Generate a resource controller class.'],
            ['type', null, InputOption::VALUE_REQUIRED, 'Manually specify the controller stub file to use.'],
        ];
    }
}
