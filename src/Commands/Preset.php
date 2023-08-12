<?php

namespace Orchestra\Canvas\Commands;

use Illuminate\Support\Str;
use Orchestra\Canvas\Processors\GeneratesPresetConfiguration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'preset', description: 'Create canvas.yaml for the project')]
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
    protected string $type = 'Preset';

    /**
     * The type of file being generated.
     *
     * @var string
     */
    protected string $fileType = 'preset';

    /**
     * Generator processor.
     *
     * @var string
     */
    protected $processor = GeneratesPresetConfiguration::class;

    /**
     * Get the stub file for the generator.
     */
    public function getStubFile(): string
    {
        $name = $this->generatorName();

        $directory = __DIR__.'/../../storage/canvas/preset';

        if (! $this->files->exists("{$directory}/{$name}.stub")) {
            $name = 'laravel';
        }

        return "{$directory}/{$name}.stub";
    }

    /**
     * Generator options.
     *
     * @return array<string, mixed>
     */
    public function generatorOptions(): array
    {
        return [
            'namespace' => $this->option('namespace'),
            'preset' => $this->generatorName(),
        ];
    }

    /**
     * Get the desired class name from the input.
     */
    public function generatorName(): string
    {
        /** @var string $name */
        $name = $this->argument('name');

        return Str::lower(trim($name));
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
