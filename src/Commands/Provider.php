<?php

namespace Orchestra\Canvas\Commands;

use Symfony\Component\Console\Input\InputOption;

/**
 * @see https://github.com/laravel/framework/blob/8.x/src/Illuminate/Foundation/Console/ProviderMakeCommand.php
 */
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
     * Get the stub file name for the generator.
     */
    public function getStubFileName(): string
    {
        return $this->option('deferred')
            ? 'provider.deferred.stub'
            : 'provider.stub';
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
     * @return array<int, array>
     */
    protected function getOptions()
    {
        return [
            ['deferred', null, InputOption::VALUE_NONE, 'Create deferrable service provider.'],
        ];
    }
}
