<?php

namespace Laravie\Canvas\Commands;

use Illuminate\Support\Str;
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
     * Build the class with the given name.
     *
     * @param  string  $name
     *
     * @return string
     */
    protected function buildClass($name)
    {
        $event = $this->option('event');

        if (! Str::startsWith($event, [
            $this->preset->rootNamespace(),
            'Illuminate',
            '\\',
        ])) {
            $event = $this->preset->rootNamespace().'Events\\'.$event;
        }

        $stub = \str_replace(
            'DummyEvent', \class_basename($event), parent::buildClass($name)
        );

        return \str_replace(
            'DummyFullEvent', \trim($event, '\\'), $stub
        );
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $directory = __DIR__.'/../../../storage/listener';

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
     * Determine if the class already exists.
     */
    protected function alreadyExists(string $rawName): bool
    {
        return \class_exists($rawName);
    }

    /**
     * Get the default namespace for the class.
     */
    protected function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Listeners';
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
