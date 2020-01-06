<?php

namespace Orchestra\Canvas\Commands;

use Symfony\Component\Console\Input\InputOption;

class Provider extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:provider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service provider class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Provider';

    /**
     * Get the stub file for the generator.
     */
    public function getStubFile(): string
    {
        $directory = __DIR__.'/../../storage/provider';

        if ($this->option('deferred')) {
            return "{$directory}/provider.deferred.stub";
        }

        return "{$directory}/provider.stub";
    }

    /**
     * Get the default namespace for the class.
     */
    public function getDefaultNamespace(string $rootNamespace): string
    {
        return $this->preset->providerNamespace();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['deferred', null, InputOption::VALUE_NONE, 'Create deferrable service provider.'],
        ];
    }
}
