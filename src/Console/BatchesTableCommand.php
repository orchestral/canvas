<?php

namespace Orchestra\Canvas\Console;

use Illuminate\Filesystem\Filesystem;
use Orchestra\Canvas\Core\Concerns\MigrationGenerator;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 * @see https://github.com/laravel/framework/blob/11.x/src/Illuminate/Queue/Console/BatchesTableCommand.php
 */
#[AsCommand(name: 'make:queue-batches-table', description: 'Create a migration for the batches database table')]
class BatchesTableCommand extends \Illuminate\Queue\Console\BatchesTableCommand
{
    use MigrationGenerator;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:queue-batches-table';

    /**
     * Create a new notifications table command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct($files);

        $this->addGeneratorPresetOptions();
    }

    /**
     * Create a base migration file for the table.
     *
     * @param  string  $table
     * @return string
     */
    #[\Override]
    protected function createBaseMigration($table)
    {
        return $this->createBaseMigrationUsingCanvas($table);
    }

    /**
     * Determine whether a migration for the table already exists.
     *
     * @param  string  $table
     * @return bool
     */
    #[\Override]
    protected function migrationExists($table)
    {
        return $this->migrationExistsUsingCanvas($table);
    }
}
