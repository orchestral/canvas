<?php

namespace Orchestra\Canvas\Commands;

use Symfony\Component\Console\Input\InputOption;

class Job extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new job class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Job';

    /**
     * Get the stub file for the generator.
     */
    public function getStubFile(): string
    {
        $directory = __DIR__.'/../../storage/job';

        return $this->option('sync')
            ? "{$directory}/job.stub"
            : "{$directory}/queued.stub";
    }

    /**
     * Get the default namespace for the class.
     */
    public function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Jobs';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['sync', null, InputOption::VALUE_NONE, 'Indicates that job should be synchronous'],
        ];
    }
}
