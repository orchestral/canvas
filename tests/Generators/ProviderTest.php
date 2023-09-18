<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

class ProviderTest extends TestCase
{
    protected $files = [
        'app/Providers/FooServiceProvider.php',
    ];

    /** @test */
    public function it_can_generate_service_provider_file()
    {
        $this->artisan('make:provider', ['name' => 'FooServiceProvider'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Providers;',
            'use Illuminate\Support\ServiceProvider;',
            'class FooServiceProvider extends ServiceProvider',
            'public function register()',
            'public function boot()',
        ], 'app/Providers/FooServiceProvider.php');

        $this->assertFileNotContains([
            'use Illuminate\Contracts\Support\DeferrableProvider;',
            'public function provides()',
        ], 'app/Providers/FooServiceProvider.php');
    }

    /** @test */
    public function it_can_generate_deferred_service_provider_file()
    {
        $this->artisan('make:provider', ['name' => 'FooServiceProvider', '--deferred' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Providers;',
            'use Illuminate\Contracts\Support\DeferrableProvider;',
            'use Illuminate\Support\ServiceProvider;',
            'class FooServiceProvider extends ServiceProvider implements DeferrableProvider',
            'public function register()',
            'public function boot()',
            'public function provides()',
        ], 'app/Providers/FooServiceProvider.php');
    }
}
