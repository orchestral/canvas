<?php

namespace Orchestra\Canvas\Console;

use Illuminate\Console\Concerns\CreatesUsingGeneratorPreset;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\Composer;
use Orchestra\Canvas\Core\Commands\Command;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 * @see https://github.com/laravel/framework/blob/9.x/src/Illuminate/Database/Console/Migrations/MigrateMakeCommand.php
 */
#[AsCommand(name: 'make:migration', description: 'Create a new migration file')]
class MigrateMakeCommand extends \Illuminate\Database\Console\Migrations\MigrateMakeCommand
{
    use CreatesUsingGeneratorPreset;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Migration';

    /**
     * Create a new migration install command instance.
     *
     * @param  \Illuminate\Database\Migrations\MigrationCreator  $creator
     * @param  \Illuminate\Support\Composer  $composer
     * @return void
     */
    public function __construct(MigrationCreator $creator, Composer $composer)
    {
        parent::__construct($creator, $composer);

        $this->addGeneratorPresetOptions();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $preset = $this->generatorPreset();

        if (! $preset->is('laravel')) {
            $this->input->setOption('path', $preset->migrationPath());
            $this->input->setOption('realpath', true);
        }

        parent::handle();
    }
}
