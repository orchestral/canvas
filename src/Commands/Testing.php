<?php

namespace Laravie\Canvas\Commands;

use Illuminate\Support\Str;

class Testing extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'test';

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
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        $directory = __DIR__.'/../../../storage/testing';

        if ($this->option('unit')) {
            return "{$directory}/unit.stub";
        }

        return "{$directory}/feature.stub";
    }

    /**
     * Get the destination class path.
     */
    protected function getPath(string $name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return \sprintf(
            '%s/tests/%s',
            $this->preset->basePath(),
            \str_replace('\\', '/', $name).'.php'
        );
    }

    /**
     * Get the default namespace for the class.
     */
    protected function getDefaultNamespace(string $rootNamespace): string
    {
        if ($this->option('unit')) {
            return $rootNamespace.'\Unit';
        }

        return $rootNamespace.'\Feature';
    }

    /**
     * Get the root namespace for the class.
     */
    protected function rootNamespace(): string
    {
        return $this->preset->config('testing.namespace', 'Tests');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['unit', null, InputOption::VALUE_OPTIONAL, 'Create a unit test'],
        ];
    }
}
