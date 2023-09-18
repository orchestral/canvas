<?php

namespace Orchestra\Canvas;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Database\Console\Factories\FactoryMakeCommand;
use Illuminate\Foundation\Console\CastMakeCommand;
use Illuminate\Foundation\Console\EventMakeCommand;
use Illuminate\Foundation\Console\ResourceMakeCommand;
use Illuminate\Foundation\Console\RuleMakeCommand;
use Illuminate\Foundation\Console\TestMakeCommand;
use Illuminate\Routing\Console\MiddlewareMakeCommand;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $devCommands = [
        // 'CastMake' => CastMakeCommand::class,
        // 'ChannelMake' => ChannelMakeCommand::class,
        // 'ComponentMake' => ComponentMakeCommand::class,
        // 'ConsoleMake' => ConsoleMakeCommand::class,
        // 'ControllerMake' => ControllerMakeCommand::class,
        // 'EventGenerate' => EventGenerateCommand::class,
        // 'EventMake' => EventMakeCommand::class,
        // 'ExceptionMake' => ExceptionMakeCommand::class,
        // 'JobMake' => JobMakeCommand::class,
        // 'ListenerMake' => ListenerMakeCommand::class,
        // 'MailMake' => MailMakeCommand::class,
        // 'MiddlewareMake' => MiddlewareMakeCommand::class,
        // 'ModelMake' => ModelMakeCommand::class,
        // 'NotificationMake' => NotificationMakeCommand::class,
        // 'NotificationTable' => NotificationTableCommand::class,
        // 'ObserverMake' => ObserverMakeCommand::class,
        // 'PolicyMake' => PolicyMakeCommand::class,
        // 'ProviderMake' => ProviderMakeCommand::class,
        // 'QueueFailedTable' => FailedTableCommand::class,
        // 'QueueTable' => TableCommand::class,
        // 'QueueBatchesTable' => BatchesTableCommand::class,
        // 'RequestMake' => RequestMakeCommand::class,
        // 'ScopeMake' => ScopeMakeCommand::class,
        // 'SeederMake' => SeederMakeCommand::class,
        // 'SessionTable' => SessionTableCommand::class,
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCastMakeCommand();
        $this->registerChannelMakeCommand();
        $this->registerEventMakeCommand();
        $this->registerFactoryMakeCommand();
        $this->registerJobMakeCommand();
        $this->registerMiddlewareMakeCommand();
        $this->registerResourceMakeCommand();
        $this->registerRuleMakeCommand();
        $this->registerTestMakeCommand();

        $this->commands([
            Console\CastMakeCommand::class,
            Console\ChannelMakeCommand::class,
            Console\EventMakeCommand::class,
            Console\FactoryMakeCommand::class,
            Console\JobMakeCommand::class,
            Console\MiddlewareMakeCommand::class,
            Console\ResourceMakeCommand::class,
            Console\RuleMakeCommand::class,
            Console\TestMakeCommand::class,
        ]);
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerCastMakeCommand()
    {
        $this->app->singleton(CastMakeCommand::class, function ($app) {
            return new Console\CastMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerChannelMakeCommand()
    {
        $this->app->singleton(ChannelMakeCommand::class, function ($app) {
            return new Console\ChannelMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerEventMakeCommand()
    {
        $this->app->singleton(EventMakeCommand::class, function ($app) {
            return new Console\EventMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerFactoryMakeCommand()
    {
        $this->app->singleton(FactoryMakeCommand::class, function ($app) {
            return new Console\FactoryMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerJobMakeCommand()
    {
        $this->app->singleton(JobMakeCommand::class, function ($app) {
            return new Console\JobMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMiddlewareMakeCommand()
    {
        $this->app->singleton(MiddlewareMakeCommand::class, function ($app) {
            return new Console\MiddlewareMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerResourceMakeCommand()
    {
        $this->app->singleton(ResourceMakeCommand::class, function ($app) {
            return new Console\ResourceMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerRuleMakeCommand()
    {
        $this->app->singleton(RuleMakeCommand::class, function ($app) {
            return new Console\RuleMakeCommand($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerTestMakeCommand()
    {
        $this->app->singleton(TestMakeCommand::class, function ($app) {
            return new Console\TestMakeCommand($app['files']);
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
            CastMakeCommand::class,
            Console\CastMakeCommand::class,
            ChannelMakeCommand::class,
            Console\ChannelMakeCommand::class,
            FactoryMakeCommand::class,
            Console\FactoryMakeCommand::class,
            JobMakeCommand::class,
            Console\JobMakeCommand::class,
            MiddlewareMakeCommand::class,
            Console\MiddlewareMakeCommand::class,
            ResourceMakeCommand::class,
            Console\ResourceMakeCommand::class,
            RuleMakeCommand::class,
            Console\RuleMakeCommand::class,
            TestMakeCommand::class,
            Console\TestMakeCommand::class,
        ];
    }
}
