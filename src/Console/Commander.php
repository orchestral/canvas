<?php

namespace Orchestra\Canvas\Console;

use Illuminate\Contracts\Console\Kernel as ConsoleKernel;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\Collection;
use Orchestra\Canvas\Core\Concerns\CreatesUsingGeneratorPreset;
use Orchestra\Canvas\LaravelServiceProvider;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class Commander extends \Orchestra\Testbench\Console\Commander
{
    /**
     * The environment file name.
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
                ->reject(
                    static fn (SymfonyCommand $command, string $name) => \in_array(CreatesUsingGeneratorPreset::class, class_uses_recursive($command))
                )->each(static function (SymfonyCommand $command) {
                    $command->setHidden(true);
                });
        }

        /** @phpstan-ignore return.type */
        return $this->app;
    }
}
