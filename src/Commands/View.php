<?php

namespace Orchestra\Canvas\Commands;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Orchestra\Canvas\Processors\GeneratesViewCode;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * @see https://github.com/laravel/framework/blob/10.x/src/Illuminate/Foundation/Console/ViewMakeCommand.php
 */
#[AsCommand(name: 'make:view', description: 'Create a new view')]
class View extends Generator
{
    use CreatesMatchingTest;

    /**
     * The type of file being generated.
     *
     * @var string
     */
    protected string $type = 'View';

    /**
     * Generator processor.
     *
     * @var class-string<\Orchestra\Canvas\Core\GeneratesCode>
     */
    protected string $processor = GeneratesViewCode::class;

    /**
     * Handle generating code.
     */
    public function generatingCode(string $stub, string $name): string
    {
        $stub = parent::generatingCode($stub, $name);

        return str_replace(
            '{{ quote }}',
            Inspiring::quotes()->random(),
            $stub,
        );
    }

    /**
     * Get the stub file name for the generator.
     */
    public function getStubFileName(): string
    {
        return 'view.stub';
    }

    /**
     * Generator options.
     *
     * @return array<string, mixed>
     */
    public function generatorOptions(): array
    {
        return array_merge(parent::generatorOptions(), [
            'extension' => $this->option('extension'),
            'force' => $this->option('force'),
        ]);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['extension', null, InputOption::VALUE_OPTIONAL, 'The extension of the generated view', 'blade.php'],
            ['force', 'f', InputOption::VALUE_NONE, 'Create the view even if the view already exists'],
        ];
    }
}
