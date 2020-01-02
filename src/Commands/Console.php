<?php

namespace Laravie\Canvas\Commands;

use Symfony\Component\Console\Input\InputOption;

class Console extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Artisan command';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Console command';

    /**
     * The type of file being generated.
     *
     * @var string
     */
    protected $fileType = 'command';

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     *
     * @return string
     */
    protected function replaceClass(string $stub, string $name): string
    {
        $stub = parent::replaceClass($stub, $name);

        return \str_replace('dummy:command', $this->option('command'), $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__.'/../../../storage/laravel/console.stub';
    }

    /**
     * Get the default namespace for the class.
     */
    protected function getDefaultNamespace(string $rootNamespace): string
    {
        return $this->preset->config('console.namespace', $rootNamespace.'\Console\Commands');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['command', null, InputOption::VALUE_OPTIONAL, 'The terminal command that should be assigned', 'command:name'],
        ];
    }
}
