<?php

namespace Orchestra\Canvas\Processors;

use Illuminate\Support\Str;

class GeneratesObserverCode extends GeneratesCode
{
    /**
     * Build the class with the given name.
     */
    protected function buildClass(string $name): string
    {
        $stub = parent::buildClass($name);

        $model = $this->options['model'];

        return ! empty($model) ? $this->replaceModel($stub, $model) : $stub;
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

        $model = \class_basename(\trim($model, '\\'));

        $stub = \str_replace('DocDummyModel', Str::snake($model, ' '), $stub);

        $stub = \str_replace('DummyModel', $model, $stub);

        return \str_replace('dummyModel', Str::camel($model), $stub);
    }
}
