<?php

namespace Orchestra\Canvas\Console;

use Illuminate\Filesystem\Filesystem;
use Orchestra\Canvas\Core\Concerns\CodeGenerator;
use Orchestra\Canvas\Core\Concerns\TestGenerator;
use Orchestra\Canvas\Core\Concerns\UsesGeneratorOverrides;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 * @see https://github.com/laravel/framework/blob/9.x/src/Illuminate/Foundation/Console/JobMakeCommand.php
 */
#[AsCommand(name: 'make:job', description: 'Create a new job class')]
class JobMakeCommand extends \Illuminate\Foundation\Console\JobMakeCommand
{
    use CodeGenerator;
    use TestGenerator;
    use UsesGeneratorOverrides;

    /**
     * Create a new controller creator command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct($files);

        $this->addGeneratorPresetOptions();
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        return $this->generateCode() ? self::SUCCESS : self::FAILURE;
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        return $this->getPathUsingCanvas($name);
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->rootNamespaceUsingCanvas();
    }

    /**
     * Get the model for the default guard's user provider.
     *
     * @return string|null
     */
    protected function userProviderModel(): ?string
    {
        return $this->userProviderModelUsingCanvas();
    }

    /**
     * Get the first view directory path from the application configuration.
     *
     * @param  string  $path
     * @return string
     */
    protected function viewPath($path = '')
    {
        return $this->viewPathUsingCanvas($path);
    }
}
