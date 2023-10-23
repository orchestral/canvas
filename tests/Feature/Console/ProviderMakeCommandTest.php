<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Presets\Laravel;
use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProviderMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Providers/FooServiceProvider.php',
        'app/FooServiceProvider.php',
    ];

    #[Test]
    public function it_can_generate_service_provider_file()
    {
        $this->artisan('make:provider', ['name' => 'FooServiceProvider', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Providers;',
            'use Illuminate\Support\ServiceProvider;',
            'class FooServiceProvider extends ServiceProvider',
            'public function register()',
            'public function boot()',
        ], 'app/Providers/FooServiceProvider.php');
    }

    #[Test]
    public function it_can_generate_service_provider_file_with_custom_namespace()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'provider' => ['namespace' => 'App']], $this->app->basePath()
        ));

        $this->artisan('make:provider', ['name' => 'FooServiceProvider', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App;',
            'use Illuminate\Support\ServiceProvider;',
            'class FooServiceProvider extends ServiceProvider',
            'public function register()',
            'public function boot()',
        ], 'app/FooServiceProvider.php');
    }
}
