<?php

namespace Orchestra\Canvas\Commands;

use Orchestra\Canvas\Processors\GeneratesTestingCode;
use Symfony\Component\Console\Input\InputOption;

class Testing extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new test class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Test';

    /**
     * Generator processor.
     *
     * @var string
     */
    protected $processor = GeneratesTestingCode::class;

    /**
     * Get the stub file for the generator.
     */
    public function getStubFile(): string
    {
        $directory = __DIR__.'/../../storage/testing';

        if ($this->option('unit')) {
            return "{$directory}/unit.stub";
        }

        if ($this->preset->name() === 'package') {
            return "{$directory}/feature.package.stub";
        }

        return "{$directory}/feature.stub";
    }

    /**
     * Get the default namespace for the class.
     */
    public function getDefaultNamespace(string $rootNamespace): string
    {
        if ($this->option('unit')) {
            return $rootNamespace.'\Unit';
        }

        return $rootNamespace.'\Feature';
    }

    /**
     * Generator options.
     */
    public function generatorOptions(): array
    {
        return \array_merge(parent::generatorOptions(), [
            'unit' => $this->option('unit'),
            'feature' => ! $this->option('unit'),
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
            ['unit', null, InputOption::VALUE_NONE, 'Create a unit test'],
        ];
    }
}
