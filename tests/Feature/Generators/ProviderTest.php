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
        ], 'app/Providers/FooServiceProvider.php');
    }
}
