<?php

namespace Orchestra\Canvas\Commands\Database;

use Orchestra\Canvas\Commands\Generator;
use Orchestra\Canvas\Processors\GeneratesFactoryCode;
use Symfony\Component\Console\Input\InputOption;

class Factory extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:factory';

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
     * Generator processor.
     *
     * @var string
     */
    protected $processor = GeneratesFactoryCode::class;

    /**
     * Get the stub file for the generator.
     */
    public function getStubFile(): string
    {
        return $this->getStubFileFromPresetStorage($this->preset, 'factory.stub');
    }

    /**
     * Generator options.
     */
    public function generatorOptions(): array
    {
        return \array_merge(parent::generatorOptions(), [
            'model' => $this->option('model'),
        ]);
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
