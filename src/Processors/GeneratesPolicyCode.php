<?php

namespace Orchestra\Canvas\Processors;

use Illuminate\Support\Str;

class GeneratesPolicyCode extends GeneratesCode
{
    /**
     * Build the class with the given name.
     */
    protected function buildClass(string $name): string
    {
        $stub = $this->replaceUserNamespace(
            parent::buildClass($name)
        );

        $model = $this->options['model'];

        return ! empty($model) ? $this->replaceModel($stub, $model) : $stub;
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

        $namespaceModel = $this->preset->modelNamespace().'\\'.$model;

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
}
