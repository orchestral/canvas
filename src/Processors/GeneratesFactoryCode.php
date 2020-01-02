<?php

namespace Orchestra\Canvas\Processors;

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

        $model = \class_basename($namespaceModel);

        return \str_replace(
            ['NamespacedDummyModel', 'DummyModel'],
            [$namespaceModel, $model],
            parent::buildClass($name)
        );
    }

    /**
     * Get the destination class path.
     */
    protected function getPath(string $name): string
    {
        $name = \str_replace(
            ['\\', '/'], '', $this->name
        );

        return $this->preset->factoryPath()."/{$name}.php";
    }
}
