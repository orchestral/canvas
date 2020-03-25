<?php

namespace Orchestra\Canvas\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ConsoleGenerator extends Console
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:generator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new generator command';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Generator command';

    /**
     * Get the stub file for the generator.
     */
    public function getPublishedStubFileName(): ?string
    {
        return null;
    }

    /**
     * Get the stub file for the generator.
     */
    public function getStubFile(): string
    {
        return __DIR__.'/../../storage/canvas/generator.stub';
    }

    /**
     * Generator options.
     */
    public function generatorOptions(): array
    {
        $command = $this->option('command');

        if (! Str::startsWith($command, 'make:')) {
            $command = "make:{$command}";
        }

        return [
            'command' => $command,
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
            ['command', null, InputOption::VALUE_OPTIONAL, 'The terminal command that should be assigned', 'make:name'],
        ];
    }
}
