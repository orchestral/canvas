<?php

namespace Orchestra\Canvas\Console;

use Illuminate\Console\Command;
use Orchestra\Canvas\Core\Concerns\MigrationGenerator;

#[AsCommand(name: 'notifications:table', description: 'Create a migration for the notifications table')]
class NotificationTableCommand extends \Illuminate\Notifications\Console\NotificationTableCommand
{
    use MigrationGenerator;

    /**
     * Create a new notifications table command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  \Illuminate\Support\Composer  $composer
     * @return void
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct($files);

        $this->addGeneratorPresetOptions();
    }


    /**
     * Create a base migration file for the notifications.
     *
     * @return string
     */
    protected function createBaseMigration()
    {
        return $this->createBaseMigrationUsingCanvas('notifications');
    }
}
