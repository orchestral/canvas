<?php

namespace Orchestra\Canvas\Commands;

use Orchestra\Canvas\Processors\GeneratesPolicyCode;
use Symfony\Component\Console\Input\InputOption;

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
    protected $type = 'Policy';

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
        $directory = __DIR__.'/../../storage/policy';

        return $this->option('model')
            ? "{$directory}/policy.stub"
            : "{$directory}/plain.stub";
    }

    /**
     * Get the default namespace for the class.
     */
    public function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Policies';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the policy applies to'],
        ];
    }
}
