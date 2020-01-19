<?php

namespace Orchestra\Canvas\Commands;

use Orchestra\Canvas\Core\Commands\Generator;
use Orchestra\Canvas\Processors\GeneratesListenerCode;
use Symfony\Component\Console\Input\InputOption;

class Listener extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:listener';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new event listener class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Listener';

    /**
     * Generator processor.
     *
     * @var string
     */
    protected $processor = GeneratesListenerCode::class;

    /**
     * Get the stub file for the generator.
     */
    public function getStubFile(): string
    {
        $directory = __DIR__.'/../../storage/listener';

        if ($this->option('queued')) {
            return $this->option('event')
                ? "{$directory}/queued.stub"
                : "{$directory}/queued-duck.stub";
        }

        return $this->option('event')
            ? "{$directory}/listener.stub"
            : "{$directory}/listener-duck.stub";
    }

    /**
     * Get the default namespace for the class.
     */
    public function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Listeners';
    }

    /**
     * Generator options.
     */
    public function generatorOptions(): array
    {
        return [
            'event' => $this->option('event'),
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
            ['event', 'e', InputOption::VALUE_OPTIONAL, 'The event class being listened for'],
            ['queued', null, InputOption::VALUE_NONE, 'Indicates the event listener should be queued'],
        ];
    }
}
