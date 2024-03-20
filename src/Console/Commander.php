<?php

namespace Orchestra\Canvas\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Console\Kernel as ConsoleKernel;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\Collection;
use Orchestra\Canvas\LaravelServiceProvider;
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
        \Orchestra\Canvas\CanvasServiceProvider::class,
        \Orchestra\Canvas\Core\LaravelServiceProvider::class,
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

            $app->register(LaravelServiceProvider::class);

            Collection::make($kernel->all())
                ->reject(static function (SymfonyCommand $command, string $name) {
                    return $command instanceof GeneratorCommand
                        || $command instanceof MigrateMakeCommand;
                })->each(static function (SymfonyCommand $command) {
                    $command->setHidden(true);
                });
        }

        return $this->app;
    }
}
