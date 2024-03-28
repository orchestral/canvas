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

            /**
             * @param  \Illuminate\Support\Collection<string, \Illuminate\Console\SymfonyCommand>  $commands
             * @param  \Illuminate\Support\Collection<string, \Illuminate\Console\SymfonyCommand>  $rejects
             */
            [$commands, $rejects] = Collection::make($kernel->all())
                ->partition(
                    static fn (SymfonyCommand $command, string $name) => \in_array(CreatesUsingGeneratorPreset::class, class_uses_recursive($command))
                );

            $rejects->each(static function (SymfonyCommand $command) {
                $command->setHidden(true);
            });

            $commands->each(function ($command) {
                var_dump($command::class);
            });
        }

        return $this->app;
    }
}
