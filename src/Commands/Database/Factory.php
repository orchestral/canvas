<?php

namespace Orchestra\Canvas\Commands\Database;

use Orchestra\Canvas\Commands\Generator;
use Orchestra\Canvas\Processors\GeneratesFactoryCode;
use Symfony\Component\Console\Input\InputOption;

/**
 * @see https://github.com/laravel/framework/blob/9.x/src/Illuminate/Database/Console/Factories/FactoryMakeCommand.php
 */
#[\Symfony\Component\Console\Attribute\AsCommand(name: 'make:factory')]
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
    public function getPublishedStubFileName(): ?string
    {
        return $this->getStubFileName();
    }

    /**
     * Get the stub file for the generator.
     */
    public function getStubFile(): string
    {
        return $this->getStubFileFromPresetStorage($this->preset, $this->getStubFileName());
    }

    /**
     * Get the stub file name for the generator.
     */
    public function getStubFileName(): string
    {
        return 'factory.stub';
    }

    /**
     * Generator options.
     *
     * @return array<string, mixed>
     */
    public function generatorOptions(): array
    {
        return array_merge(parent::generatorOptions(), [
            'model' => $this->option('model'),
            'force' => $this->option('force'),
        ]);
    }

    /**
     * Get the console command options.
     *
     * @return array<int, array>
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the factory already exists'],
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The name of the model'],
        ];
    }
}
