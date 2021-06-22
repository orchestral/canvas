<?php

namespace Orchestra\Canvas\Commands;

use Orchestra\Canvas\Core\GeneratesCommandCode;
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
     * Generator processor.
     *
     * @var string
     */
    protected $processor = GeneratesCommandCode::class;

    /**
     * Get the stub file for the generator.
     */
    public function getPublishedStubFileName(): ?string
    {
        return 'console.stub';
    }

    /**
     * Get the stub file for the generator.
     */
    public function getStubFile(): string
    {
        return $this->getStubFileFromPresetStorage($this->preset, $this->getStubFileName());
    }

    /**
     * Get the stub file name for the generator.
     */
    public function getStubFileName(): string
    {
        return 'console.stub';
    }

    /**
     * Get the default namespace for the class.
     */
    public function getDefaultNamespace(string $rootNamespace): string
    {
        return $this->preset->config('console.namespace', $rootNamespace.'\Console\Commands');
    }

    /**
     * Generator options.
     */
    public function generatorOptions(): array
    {
        return [
            'command' => $this->option('command'),
        ];
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
