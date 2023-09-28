<?php

namespace Orchestra\Canvas;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Database\Console\Factories\FactoryMakeCommand;
use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use Illuminate\Foundation\Console\TestMakeCommand;
use Illuminate\Foundation\Console\ViewMakeCommand;
use Illuminate\Notifications\Console\NotificationTableCommand;
use Illuminate\Queue\Console\BatchesTableCommand;
use Illuminate\Queue\Console\FailedTableCommand;
use Illuminate\Queue\Console\TableCommand as QueueTableCommand;
use Illuminate\Session\Console\SessionTableCommand;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFactoryMakeCommand();
        $this->registerMigrateMakeCommand();
        $this->registerTestMakeCommand();
        $this->registerViewMakeCommand();

        $this->registerNotificationTableCommand();
        $this->registerQueueBatchesTableCommand();
        $this->registerQueueFailedTableCommand();
        $this->registerQueueTableCommand();
        $this->registerSessionTableCommand();

        $this->registerUserFactoryMakeCommand();
        $this->registerUserModelMakeCommand();

        $this->commands([
            Console\FactoryMakeCommand::class,
            Console\MigrateMakeCommand::class,
            Console\TestMakeCommand::class,
            Console\ViewMakeCommand::class,

            Console\BatchesTableCommand::class,
            Console\FailedTableCommand::class,
            Console\NotificationTableCommand::class,
            Console\QueueTableCommand::class,
            Console\SessionTableCommand::class,

            Console\UserFactoryMakeCommand::class,
            Console\UserModelMakeCommand::class,
        ]);
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerFactoryMakeCommand()
    {
        $this->app->singleton(FactoryMakeCommand::class, static function ($app) {
            return new Console\FactoryMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMigrateMakeCommand()
    {
        $this->app->singleton(MigrateMakeCommand::class, static function ($app) {
            // Once we have the migration creator registered, we will create the command
            // and inject the creator. The creator is responsible for the actual file
            // creation of the migrations, and may be extended by these developers.
            $creator = $app['migration.creator'];

            $composer = $app['composer'];

            return new Console\MigrateMakeCommand($creator, $composer);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerTestMakeCommand()
    {
        $this->app->singleton(TestMakeCommand::class, static function ($app) {
            return new Console\TestMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerViewMakeCommand()
    {
        $this->app->singleton(ViewMakeCommand::class, static function ($app) {
            return new Console\ViewMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerNotificationTableCommand()
    {
        $this->app->singleton(NotificationTableCommand::class, static function ($app) {
            return new Console\NotificationTableCommand($app['files'], $app['composer']);
        });
    }
    
    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerQueueBatchesTableCommand()
    {
        $this->app->singleton(BatchesTableCommand::class, static function ($app) {
            return new Console\BatchesTableCommand($app['files'], $app['composer']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerQueueFailedTableCommand()
    {
        $this->app->singleton(FailedTableCommand::class, static function ($app) {
            return new Console\FailedTableCommand($app['files'], $app['composer']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerQueueTableCommand()
    {
        $this->app->singleton(QueueTableCommand::class, static function ($app) {
            return new Console\QueueTableCommand($app['files'], $app['composer']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerSessionTableCommand()
    {
        $this->app->singleton(SessionTableCommand::class, static function ($app) {
            return new Console\SessionTableCommand($app['files'], $app['composer']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerUserFactoryMakeCommand()
    {
        $this->app->singleton(Console\UserFactoryMakeCommand::class, static function ($app) {
            return new Console\UserFactoryMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerUserModelMakeCommand()
    {
        $this->app->singleton(Console\UserModelMakeCommand::class, static function ($app) {
            return new Console\UserModelMakeCommand($app['files']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            FactoryMakeCommand::class,
            Console\FactoryMakeCommand::class,
            MigrateMakeCommand::class,
            Console\MigrateMakeCommand::class,
            TestMakeCommand::class,
            Console\TestMakeCommand::class,
            ViewMakeCommand::class,
            Console\ViewMakeCommand::class,

            BatchesTableCommand::class,
            Console\BatchesTableCommand::class,
            FailedTableCommand::class,
            Console\FailedTableCommand::class,
            NotificationTableCommand::class,
            Console\NotificationTableCommand::class,
            QueueTableCommand::class,
            Console\QueueTableCommand::class,
            SessionTableCommand::class,
            Console\SessionTableCommand::class,

            Console\UserFactoryMakeCommand::class,
            Console\UserModelMakeCommand::class,
        ];
    }
}
