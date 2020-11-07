<?php

namespace Orchestra\Canvas\Processors;

use Illuminate\Support\Str;
use Orchestra\Canvas\Core\GeneratesCode;

class GeneratesFactoryCode extends GeneratesCode
{
    /**
     * Build the class with the given name.
     */
    protected function buildClass(string $name): string
    {
        $namespaceModel = ! empty($this->options['model'])
            ? $this->qualifyClass($this->options['model'])
            : \trim($this->rootNamespace(), '\\').'\\Model';

        $model = class_basename($namespaceModel);

        if (Str::startsWith($namespaceModel, 'App\\Models')) {
            $namespace = Str::beforeLast('Database\\Factories\\'.Str::after($namespaceModel, 'App\\Models\\'), '\\');
        } else {
            $namespace = 'Database\\Factories';
        }

        $replace = [
            '{{ factoryNamespace }}' => $namespace,
            'NamespacedDummyModel' => $namespaceModel,
            '{{ namespacedModel }}' => $namespaceModel,
            '{{namespacedModel}}' => $namespaceModel,
            'DummyModel' => $model,
            '{{ factory }}' => $model,
            '{{factory}}' => $model,
            '{{ model }}' => $model,
            '{{model}}' => $model,
        ];

        return \str_replace(
            \array_keys($replace), \array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * Get the destination class path.
     */
    protected function getPath(string $name): string
    {
        $name = \str_replace(
            ['\\', '/'], '', $this->listener->generatorName()
        );

        return $this->preset->factoryPath()."/{$name}.php";
    }
}
