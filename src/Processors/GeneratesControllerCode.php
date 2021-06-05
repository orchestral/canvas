<?php

namespace Orchestra\Canvas\Processors;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Orchestra\Canvas\Core\GeneratesCode;

class GeneratesControllerCode extends GeneratesCode
{
    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     */
    protected function buildClass(string $name): string
    {
        $controllerNamespace = $this->getNamespace($name);

        $rootNamespace = $this->rootNamespace();

        $replace = [];

        if ($this->options['parent']) {
            $replace = $this->buildParentReplacements();
        }

        if ($this->options['model']) {
            $replace = $this->buildModelReplacements($replace);
        }

        $replace = array_merge($replace, [
            "use {$controllerNamespace}\Controller;\n" => '',
            "use {$rootNamespace}\Http\Controllers\Controller;" => "use {$rootNamespace}Http\Controllers\Controller;",
        ]);

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * Build the replacements for a parent controller.
     */
    protected function buildParentReplacements(): array
    {
        $parentModelClass = $this->parseModel($this->options['parent']);

        if (! class_exists($parentModelClass) && method_exists($this->listener, 'createModel')) {
            $this->listener->createModel($parentModelClass);
        }

        return [
            'ParentDummyFullModelClass' => $parentModelClass,
            '{{ namespacedParentModel }}' => $parentModelClass,
            '{{namespacedParentModel}}' => $parentModelClass,
            'ParentDummyModelClass' => class_basename($parentModelClass),
            '{{ parentModel }}' => class_basename($parentModelClass),
            '{{parentModel}}' => class_basename($parentModelClass),
            'ParentDummyModelVariable' => lcfirst(class_basename($parentModelClass)),
            '{{ parentModelVariable }}' => lcfirst(class_basename($parentModelClass)),
            '{{parentModelVariable}}' => lcfirst(class_basename($parentModelClass)),
        ];
    }

    /**
     * Build the model replacement values.
     */
    protected function buildModelReplacements(array $replace): array
    {
        $modelClass = $this->parseModel($this->options['model']);

        if (! class_exists($modelClass) && method_exists($this->listener, 'createModel')) {
            $this->listener->createModel($modelClass);
        }

        return array_merge($replace, [
            'DummyFullModelClass' => $modelClass,
            '{{ namespacedModel }}' => $modelClass,
            '{{namespacedModel}}' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            '{{ model }}' => class_basename($modelClass),
            '{{model}}' => class_basename($modelClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
            '{{ modelVariable }}' => lcfirst(class_basename($modelClass)),
            '{{modelVariable}}' => lcfirst(class_basename($modelClass)),
        ]);
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @throws \InvalidArgumentException
     */
    protected function parseModel(string $model): string
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');

        if (! Str::startsWith($model, $rootNamespace = $this->preset->modelNamespace())) {
            $model = $rootNamespace.'\\'.$model;
        }

        return $model;
    }
}
