<?php

namespace Orchestra\Canvas\Console;

use Illuminate\Filesystem\Filesystem;
use Orchestra\Canvas\Core\Concerns\MigrationGenerator;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 * @see https://github.com/laravel/framework/blob/11.x/src/Illuminate/Notifications/Console/NotificationTableCommand.php
 */
#[AsCommand(name: 'make:notifications-table', description: 'Create a migration for the notifications table')]
class NotificationTableCommand extends \Illuminate\Notifications\Console\NotificationTableCommand
{
    use MigrationGenerator;

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
