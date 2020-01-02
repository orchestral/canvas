<?php

namespace Orchestra\Canvas\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class Preset extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'preset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create canvas.yaml for the project';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Preset';

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        $name = $this->getNameInput();

        $directory = __DIR__.'/../../storage/preset';

        if (! $this->files->exists("{$directory}/{$name}.stub")) {
            $name = 'laravel';
        }

        return "{$directory}/{$name}.stub";
    }

    /**
     * Get the destination class path.
     */
    protected function getPath(string $name): string
    {
        return $this->preset->basePath().'/canvas.yaml';
    }

    /**
     * Get the desired class name from the input.
     */
    protected function getNameInput(): string
    {
        return Str::lower(\trim($this->argument('name')));
    }

    /**
     * Get the root namespace for the class.
     */
    protected function rootNamespace(): string
    {
        $namespace = \trim($this->option('namespace'));

        if (! empty($namespace)) {
            return $namespace;
        }

        switch ($this->getNameInput()) {
            case 'package':
                return 'PackageName';
            case 'laravel':
            default:
                return 'App';
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['namespace', null, InputOption::VALUE_OPTIONAL, 'Root namespace'],
        ];
    }
}
