<?php

namespace Orchestra\Canvas;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Database\Console\Factories\FactoryMakeCommand;
use Illuminate\Foundation\Console\RuleMakeCommand;
use Illuminate\Foundation\Console\TestMakeCommand;
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
        'FactoryMake' => FactoryMakeCommand::class,
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
        // 'ResourceMake' => ResourceMakeCommand::class,
        // 'RuleMake' => RuleMakeCommand::class,
        // 'ScopeMake' => ScopeMakeCommand::class,
        // 'SeederMake' => SeederMakeCommand::class,
        // 'SessionTable' => SessionTableCommand::class,
        'TestMake' => TestMakeCommand::class,
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFactoryMakeCommand();
        $this->registerRuleMakeCommand();
        $this->registerTestMakeCommand();
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

        $this->commands([
            Console\FactoryMakeCommand::class,
        ]);
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

        $this->commands([
            Console\RuleMakeCommand::class,
        ]);
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

        $this->commands([
            Console\TestMakeCommand::class,
        ]);
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

            RuleMakeCommand::class,
            Console\RuleMakeCommand::class,

            TestMakeCommand::class,
            Console\TestMakeCommand::class,
        ];
    }
}
