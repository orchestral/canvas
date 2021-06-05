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
                $preset = $app->make('orchestra.canvas');

                $artisan->add(new Commands\Channel($preset));
                $artisan->add(new Commands\Component($preset));
                $artisan->add(new Commands\Console($preset));
                $artisan->add(new Commands\Event($preset));
                $artisan->add(new Commands\Exception($preset));
                $artisan->add(new Commands\Database\Cast($preset));
                $artisan->add(new Commands\Database\Eloquent($preset));
                $artisan->add(new Commands\Database\Factory($preset));
                $artisan->add(new Commands\Database\Migration($preset));
                $artisan->add(new Commands\Database\Observer($preset));
                $artisan->add(new Commands\Database\Seeder($preset));
                $artisan->add(new Commands\Job($preset));
                $artisan->add(new Commands\Listener($preset));
                $artisan->add(new Commands\Mail($preset));
                $artisan->add(new Commands\Notification($preset));
                $artisan->add(new Commands\Policy($preset));
                $artisan->add(new Commands\Provider($preset));
                $artisan->add(new Commands\Request($preset));
                $artisan->add(new Commands\Resource($preset));
                $artisan->add(new Commands\Routing\Controller($preset));
                $artisan->add(new Commands\Routing\Middleware($preset));
                $artisan->add(new Commands\Rule($preset));
                $artisan->add(new Commands\StubPublish($preset));
                $artisan->add(new Commands\Testing($preset));

                $preset->addAdditionalCommands($artisan);
            });
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
