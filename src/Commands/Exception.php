<?php

namespace Laravie\Canvas\Commands;

use Symfony\Component\Console\Input\InputOption;

class Exception extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:exception';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new custom exception class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Exception';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        $directory = __DIR__.'/../../../storage/exception';

        if ($this->option('render')) {
            return $this->option('report')
                ? "{$directory}/render-and-report.stub"
                : "{$directory}/render.stub";
        }

        return $this->option('report')
            ? "{$directory}/report.stub"
            : "{$directory}/exception.stub";
    }

    /**
     * Determine if the class already exists.
     */
    protected function alreadyExists(string $rawName): bool
    {
        return \class_exists($this->getDefaultNamespace($this->rootNamespace()).'\\'.$rawName);
    }

    /**
     * Get the default namespace for the class.
     */
    protected function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Exceptions';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['render', null, InputOption::VALUE_NONE, 'Create the exception with an empty render method'],
            ['report', null, InputOption::VALUE_NONE, 'Create the exception with an empty report method'],
        ];
    }
}
