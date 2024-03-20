<?php

namespace Orchestra\Canvas\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Console\Kernel as ConsoleKernel;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class Commander extends \Orchestra\Testbench\Console\Commander
{
    /**
     * The environment file name.
     *
     * @var string
     */
    protected string $environmentFile = '.env';

    /**
     * List of providers.
     *
     * @var array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected array $providers = [
        \Orchestra\Canvas\Core\LaravelServiceProvider::class,
        \Orchestra\Canvas\CanvasServiceProvider::class,
        \Orchestra\Canvas\LaravelServiceProvider::class,
    ];

    /**
     * Create Laravel application.
     *
     * @return \Illuminate\Foundation\Application
     */
    #[\Override]
    public function laravel()
    {
        if (! $this->app instanceof LaravelApplication) {
            $app = parent::laravel();

            /** @var \Illuminate\Contracts\Console\Kernel $kernel */
            $kernel = $app->make(ConsoleKernel::class);

            Collection::make($kernel->all())
                ->reject(static function (SymfonyCommand $command, string $name) {
                    return $command instanceof GeneratorCommand
                        || $command instanceof MigrateMakeCommand
                        || $command instanceof BatchesTableCommand
                        || $command instanceof CacheTableCommand
                        || $command instanceof FailedTableCommand
                        || $command instanceof NotificationTableCommand
                        || $command instanceof QueueTableCommand
                        || $command instanceof SessionTableCommand;
                })->each(static function (SymfonyCommand $command) {
                    $command->setHidden(true);
                });
        }

        return $this->app;
    }
}
