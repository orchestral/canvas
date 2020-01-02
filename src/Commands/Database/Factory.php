<?php

namespace Laravie\Canvas\Commands\Database;

use Laravie\Canvas\Commands\Generator;
use Symfony\Component\Console\Input\InputOption;

class Factory extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'factory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model factory';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Factory';

    /**
     * Build the class with the given name.
     */
    protected function buildClass(string $name): string
    {
        $namespaceModel = $this->option('model')
                        ? $this->qualifyClass($this->option('model'))
                        : \trim($this->rootNamespace(), '\\').'\\Model';

        $model = \class_basename($namespaceModel);

        return \str_replace(
            [
                'NamespacedDummyModel',
                'DummyModel',
            ],
            [
                $namespaceModel,
                $model,
            ],
            parent::buildClass($name)
        );
    }

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return __DIR__.'/../../../storage/database/factories/factory.stub';
    }

    /**
     * Get the destination class path.
     */
    protected function getPath(string $name): string
    {
        $name = \str_replace(
            ['\\', '/'], '', $this->argument('name')
        );

        return $this->preset->factoryPath()."/{$name}.php";
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The name of the model'],
        ];
    }
}
