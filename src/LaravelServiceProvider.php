<?php

namespace Orchestra\Canvas;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Yaml\Yaml;

class LaravelServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
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

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Artisan::starting(function ($artisan) {
            $preset = $this->app->make('orchestra.canvas');

            $artisan->registerCommand(new Commands\Channel($preset));
            $artisan->registerCommand(new Commands\Console($preset));
            $artisan->registerCommand(new Commands\Event($preset));
            $artisan->registerCommand(new Commands\Exception($preset));
            $artisan->registerCommand(new Commands\Database\Eloquent($preset));
            $artisan->registerCommand(new Commands\Database\Factory($preset));
            $artisan->registerCommand(new Commands\Database\Migration($preset));
            $artisan->registerCommand(new Commands\Database\Observer($preset));
            $artisan->registerCommand(new Commands\Database\Seeder($preset));
            $artisan->registerCommand(new Commands\Job($preset));
            $artisan->registerCommand(new Commands\Listener($preset));
            $artisan->registerCommand(new Commands\Mail($preset));
            $artisan->registerCommand(new Commands\Notification($preset));
            $artisan->registerCommand(new Commands\Policy($preset));
            $artisan->registerCommand(new Commands\Provider($preset));
            $artisan->registerCommand(new Commands\Request($preset));
            $artisan->registerCommand(new Commands\Resource($preset));
            $artisan->registerCommand(new Commands\Routing\Controller($preset));
            $artisan->registerCommand(new Commands\Routing\Middleware($preset));
            $artisan->registerCommand(new Commands\Rule($preset));
            $artisan->registerCommand(new Commands\Testing($preset));
        });
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
