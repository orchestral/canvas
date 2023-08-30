<?php

namespace Orchestra\Canvas\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:generator', description: 'Create a new generator command')]
class ConsoleGenerator extends Console
{
    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected string $type = 'Generator command';

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
     *
     * @return array<string, mixed>
     */
    public function generatorOptions(): array
    {
        /** @var string $command */
        $command = $this->option('command');

        if (! Str::startsWith($command, 'make:')) {
            $command = "make:{$command}";
        }

        return [
            'command' => $command,
            'force' => $this->option('force'),
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array<int, array>
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the generator already exists'],
            ['command', null, InputOption::VALUE_OPTIONAL, 'The terminal command that should be assigned', 'make:name'],
        ];
    }
}
