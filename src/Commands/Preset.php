<?php

namespace Orchestra\Canvas\Commands;

use Illuminate\Support\Str;

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

        $directory = __DIR__.'/../../../storage/preset';

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
     * Parse the class name and format according to the root namespace.
     */
    protected function qualifyClass(string $name): string
    {
        return $name;
    }

    /**
     * Get the desired class name from the input.
     */
    protected function getNameInput(): string
    {
        return Str::lower(\trim($this->argument('name')));
    }
}
