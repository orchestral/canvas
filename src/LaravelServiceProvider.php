<?php

namespace Orchestra\Canvas;

use Illuminate\Contracts\Console\Kernel as ConsoleKernel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Yaml\Yaml;

class LaravelServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->singleton('orchestra.canvas', function (Application $app) {
            $files = $app->make('files');

            $config = ['preset' => 'laravel'];

            if ($files->exists($app->basePath('canvas.yaml'))) {
                $config = Yaml::parseFile($app->basePath('canvas.yaml'));
            }

            return Canvas::preset($config, $app->basePath(), $files);
        });
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $preset = $this->app->make('orchestra.canvas');
            $kernel = $this->app->make(ConsoleKernel::class);

            $kernel->add(new Commands\Channel($preset));
            $kernel->add(new Commands\Console($preset));
            $kernel->add(new Commands\Event($preset));
            $kernel->add(new Commands\Exception($preset));
            $kernel->add(new Commands\Database\Eloquent($preset));
            $kernel->add(new Commands\Database\Factory($preset));
            $kernel->add(new Commands\Database\Migration($preset));
            $kernel->add(new Commands\Database\Observer($preset));
            $kernel->add(new Commands\Database\Seeder($preset));
            $kernel->add(new Commands\Job($preset));
            $kernel->add(new Commands\Listener($preset));
            $kernel->add(new Commands\Mail($preset));
            $kernel->add(new Commands\Notification($preset));
            $kernel->add(new Commands\Policy($preset));
            $kernel->add(new Commands\Provider($preset));
            $kernel->add(new Commands\Request($preset));
            $kernel->add(new Commands\Resource($preset));
            $kernel->add(new Commands\Routing\Controller($preset));
            $kernel->add(new Commands\Routing\Middleware($preset));
            $kernel->add(new Commands\Rule($preset));
            $kernel->add(new Commands\Testing($preset));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['orchestra.canvas'];
    }
}
