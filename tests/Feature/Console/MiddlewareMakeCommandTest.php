<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;

class MiddlewareMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Http/Middleware/Foo.php',
        'tests/Feature/Http/Middleware/FooTest.php',
    ];

    public function testItCanGenerateMiddlewareFile()
    {
        $this->artisan('make:middleware', ['name' => 'Foo', '--preset' => 'canvas'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Middleware;',
            'use Closure;',
            'use Illuminate\Http\Request;',
            'class Foo',
            'public function handle(Request $request, Closure $next)',
            'return $next($request);',
        ], 'app/Http/Middleware/Foo.php');

        $this->assertFilenameNotExists('tests/Feature/Http/Middleware/FooTest.php');
    }

    public function testItCanGenerateMiddlewareFile_with_tests()
    {
        $this->artisan('make:middleware', ['name' => 'Foo', '--test' => true, '--preset' => 'canvas'])
            ->assertExitCode(0);

        $this->assertFilenameExists('app/Http/Middleware/Foo.php');
        $this->assertFilenameExists('tests/Feature/Http/Middleware/FooTest.php');
    }
}
