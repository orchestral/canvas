<?php

namespace Orchestra\Canvas\Tests\Feature\Generators\Routing;

use Orchestra\Canvas\Tests\Feature\Generators\TestCase;

class MiddlewareTest extends TestCase
{
    protected $files = [
        'app/Http/Middleware/Foo.php',
    ];

    /** @test */
    public function it_can_generate_middleware_file()
    {
        $this->artisan('make:middleware', ['name' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Middleware;',
            'use Closure;',
            'use Illuminate\Http\Request;',
            'class Foo',
            'public function handle(Request $request, Closure $next)',
            'return $next($request);',
        ], 'app/Http/Middleware/Foo.php');
    }
}
