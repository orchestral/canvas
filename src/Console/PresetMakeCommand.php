<?php

namespace Orchestra\Canvas\Console;

use Illuminate\Support\Str;
use Orchestra\Canvas\Core\Commands\GeneratorCommand;
use Orchestra\Canvas\Core\Concerns\ResolvesPresetStubs;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'preset', description: 'Create canvas.yaml for the project')]
class PresetMakeCommand extends GeneratorCommand
{
    use ResolvesPresetStubs;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Preset';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $name = Str::lower($this->getNameInput());

        $stub = __DIR__.'/stubs/preset';

        return $this->files->exists("{$stub}.{$name}.stub")
            ? "{$stub}.{$name}.stub"
            : "{$stub}.laravel.stub";
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        return $this->generatorPreset()->basePath().'/canvas.yaml';
    }

    /**
     * Get the root namespace for the class.
     */
    protected function rootNamespace(): string
    {
        $namespace = trim($this->option('namespace')) ?? '';

        if (! empty($namespace)) {
            return $namespace;
        }

        switch ($this->options('name')) {
            case 'package':
                return 'PackageName';
            case 'laravel':
            default:
                return rtrim($this->laravel->getNamespace(), '\\');
        }
    }

    /**
     * Get the console command options.
     *
     * @return array<int, array>
     */
    protected function getOptions()
    {
        return [
            ['namespace', null, InputOption::VALUE_OPTIONAL, 'Root namespace'],
        ];
    }
}