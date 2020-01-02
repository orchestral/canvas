<?php

namespace Laravie\Canvas\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class Policy extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:policy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new policy class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Policy';

    /**
     * Build the class with the given name.
     */
    protected function buildClass(string $name): string
    {
        $stub = $this->replaceUserNamespace(
            parent::buildClass($name)
        );

        $model = $this->option('model');

        return $model ? $this->replaceModel($stub, $model) : $stub;
    }

    /**
     * Replace the User model namespace.
     */
    protected function replaceUserNamespace(string $stub): string
    {
        $model = $this->userProviderModel();

        if (! $model) {
            return $stub;
        }

        return \str_replace(
            $this->rootNamespace().'User',
            $model,
            $stub
        );
    }

    /**
     * Replace the model for the given stub.
     */
    protected function replaceModel(string $stub, string $model): string
    {
        $model = \str_replace('/', '\\', $model);

        $namespaceModel = $this->preset->roortNamespace().$model;

        if (Str::startsWith($model, '\\')) {
            $stub = \str_replace('NamespacedDummyModel', trim($model, '\\'), $stub);
        } else {
            $stub = \str_replace('NamespacedDummyModel', $namespaceModel, $stub);
        }

        $stub = \str_replace(
            "use {$namespaceModel};\nuse {$namespaceModel};", "use {$namespaceModel};", $stub
        );

        $model = \class_basename(trim($model, '\\'));

        $dummyUser = \class_basename($this->userProviderModel());

        $dummyModel = Str::camel($model) === 'user' ? 'model' : $model;

        $stub = \str_replace('DocDummyModel', Str::snake($dummyModel, ' '), $stub);

        $stub = \str_replace('DummyModel', $model, $stub);

        $stub = \str_replace('dummyModel', Str::camel($dummyModel), $stub);

        $stub = \str_replace('DummyUser', $dummyUser, $stub);

        return \str_replace('DocDummyPluralModel', Str::snake(Str::pluralStudly($dummyModel), ' '), $stub);
    }

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        $directory = __DIR__.'/../../../storage/policy';

        return $this->option('model')
            ? "{$directory}/policy.stub"
            : "{$directory}/plain.stub";
    }

    /**
     * Get the default namespace for the class.
     */
    protected function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Policies';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the policy applies to'],
        ];
    }
}
