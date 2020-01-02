<?php

namespace Laravie\Canvas\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class Factory extends Generator
{
    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Factory';

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this->setName('factory')
                ->setDescription('Create a new model factory.')
                ->addArgument('name', InputArgument::REQUIRED, 'The name of the class')
                ->addOption('model', 'm', InputOption::VALUE_OPTIONAL, 'The name of the model');
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     *
     * @return string
     */
    protected function buildClass($name)
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
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../../storage/database/factories/factory.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     *
     * @return string
     */
    protected function getPath($name)
    {
        $name = \str_replace(
            ['\\', '/'], '', $this->argument('name')
        );

        return $this->preset->factoryPath()."/{$name}.php";
    }
}
