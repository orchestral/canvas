<?php

namespace Orchestra\Canvas\Commands\Database;

use Illuminate\Support\Composer;
use Orchestra\Canvas\Commands\Generator;

class Seeder extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:seeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new seeder class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Seeder';

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        parent::configure();

        $this->composer = new Composer($this->preset->filesystem(), $this->preset->basePath());
    }

    /**
     * Execute the command.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     * @return int 0 if everything went fine, or an exit code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $exitCode = parent::execute($input, $output);

        $this->composer->dumpAutoloads();

        return $exitCode;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../../../storage/database/seeds/seeder.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     *
     * @return string
     */
    protected function getPath($name)
    {
        return $this->preset->seederPath().'/seeds/'.$name.'.php';
    }

    /**
     * Parse the class name and format according to the root namespace.
     */
    protected function qualifyClass(string $name): string
    {
        return $name;
    }
}
