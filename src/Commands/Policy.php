<?php

namespace Orchestra\Canvas\Commands;

use Orchestra\Canvas\Processors\GeneratesPolicyCode;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * @see https://github.com/laravel/framework/blob/10.x/src/Illuminate/Foundation/Console/PolicyMakeCommand.php
 */
#[AsCommand(name: 'make:policy', description: 'Create a new policy class')]
class Policy extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:policy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new policy class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected string $type = 'Policy';

    /**
     * Generator processor.
     *
     * @var string
     */
    protected $processor = GeneratesPolicyCode::class;

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
        return $this->option('model')
            ? 'policy.stub'
            : 'policy.plain.stub';
    }

    /**
     * Get the default namespace for the class.
     */
    public function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Policies';
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
     * Get the console command arguments.
     *
     * @return array<int, array>
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the policy already exists'],
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the policy applies to'],
            // ['guard', 'g', InputOption::VALUE_OPTIONAL, 'The guard that the policy relies on'],
        ];
    }
}
