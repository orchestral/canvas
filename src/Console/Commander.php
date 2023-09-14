<?php

namespace Orchestra\Canvas\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Orchestra\Canvas\CanvasServiceProvider;

class Commander extends \Orchestra\Testbench\Console\Commander
{
    /**
     * The environment file name.
     *
     * @var string
     */
    protected $environmentFile = '.env';

    /**
     * Resolve application implementation.
     *
     * @return \Closure(\Illuminate\Foundation\Application):void
     */
    protected function resolveApplicationCallback()
    {
        return function ($app) {
            $app->register(CanvasServiceProvider::class);
        };
    }


    /**
     * Create Laravel application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function laravel()
    {
        if (! $this->app instanceof LaravelApplication) {
            parent::laravel();

            $kernel = $this->app->make(ConsoleKernel::class);

            Collection::make($kernel->all())
                ->reject(function ($command, $name) {
                    return Str::startsWith('make:', $name) || $command instanceof GeneratorCommand;
                })->each(function ($command) {
                    $command->setHidden(true);
                });
        }

        return $this->app;
    }
}
