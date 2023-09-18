<?php

namespace Orchestra\Canvas;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Database\Console\Factories\FactoryMakeCommand;
use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $devCommands = [
        // 'CacheTable' => CacheTableCommand::class,
        // 'CastMake' => CastMakeCommand::class,
        // 'ChannelMake' => ChannelMakeCommand::class,
        // 'ComponentMake' => ComponentMakeCommand::class,
        // 'ConsoleMake' => ConsoleMakeCommand::class,
        // 'ControllerMake' => ControllerMakeCommand::class,
        // 'Docs' => DocsCommand::class,
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
        // 'Serve' => ServeCommand::class,
        // 'StubPublish' => StubPublishCommand::class,
        // 'TestMake' => TestMakeCommand::class,
        // 'VendorPublish' => VendorPublishCommand::class,
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFactoryMakeCommand();
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
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            FactoryMakeCommand::class,
            Console\FactoryMakeCommand::class,
        ];
    }
}
