<?php

namespace Orchestra\Canvas;

use Illuminate\Console\Application as Artisan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Yaml\Yaml;

class LaravelServiceProvider extends ServiceProvider implements DeferrableProvider
{
    use Core\CommandsProvider;

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
            } else {
                Arr::set($config, 'testing.extends', [
                    'unit' => 'PHPUnit\Framework\TestCase',
                    'feature' => 'Tests\TestCase',
                ]);

                $config['namespace'] = trim($this->app->getNamespace(), '\\');
            }

            $config['user-auth-provider'] = $this->userProviderModel();

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
        Artisan::starting(static function ($artisan) {
            $artisan->getLaravel()->booted(static function ($app) use ($artisan) {
                /**
                 * @var \Illuminate\Contracts\Foundation\Application $app
                 * @var \Illuminate\Console\Application $artisan
                 */
                $preset = $app->make('orchestra.canvas');

                $preset->addAdditionalCommands($artisan);
            });
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides()
    {
        return ['orchestra.canvas'];
    }
}
