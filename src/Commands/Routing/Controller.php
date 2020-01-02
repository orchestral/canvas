<?php

namespace Orchestra\Canvas\Commands\Routing;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Orchestra\Canvas\Commands\Generator;
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
     * Get the stub file for the generator.
     */
    public function getStubFile(): string
    {
        $stub = null;
        $directory = __DIR__.'/../../../storage/routing';

        if ($this->option('parent')) {
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
            $stub = \str_replace('.stub', '.api.stub', $stub);
        }

        $stub = $stub ?? 'controller.plain.stub';

        return "{$directory}/{$stub}";
    }

    /**
     * Get the default namespace for the class.
     */
    public function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Http\Controllers';
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     */
    protected function buildClass(string $name): string
    {
        $controllerNamespace = $this->getNamespace($name);

        $replace = [];

        if ($this->option('parent')) {
            $replace = $this->buildParentReplacements();
        }

        if ($this->option('model')) {
            $replace = $this->buildModelReplacements($replace);
        }

        $replace["use {$controllerNamespace}\Controller;\n"] = '';

        return \str_replace(
            \array_keys($replace), \array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * Build the replacements for a parent controller.
     */
    protected function buildParentReplacements(): array
    {
        $parentModelClass = $this->parseModel($this->option('parent'));

        if (! \class_exists($parentModelClass)) {
            if ($this->confirm("A {$parentModelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:model', ['name' => $parentModelClass]);
            }
        }

        return [
            'ParentDummyFullModelClass' => $parentModelClass,
            'ParentDummyModelClass' => \class_basename($parentModelClass),
            'ParentDummyModelVariable' => \lcfirst(\class_basename($parentModelClass)),
        ];
    }

    /**
     * Build the model replacement values.
     *
     * @return array
     */
    protected function buildModelReplacements(array $replace)
    {
        $modelClass = $this->parseModel($this->option('model'));

        if (! \class_exists($modelClass)) {
            if ($this->confirm("A {$modelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:model', ['name' => $modelClass]);
            }
        }

        return \array_merge($replace, [
            'DummyFullModelClass' => $modelClass,
            'DummyModelClass' => \class_basename($modelClass),
            'DummyModelVariable' => \lcfirst(\class_basename($modelClass)),
        ]);
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @throws \InvalidArgumentException
     */
    protected function parseModel(string $model): string
    {
        if (\preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = \trim(\str_replace('/', '\\', $model), '\\');

        if (! Str::startsWith($model, $rootNamespace = $this->preset->rootNamespace())) {
            $model = $rootNamespace.$model;
        }

        return $model;
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
        ];
    }
}
