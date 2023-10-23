<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Presets\Laravel;
use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CodeMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Value/Foo.php',
    ];

    #[Test]
    public function it_can_generate_class_file()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'generators' => ['Orchestra\Canvas\Commands\Code']], $this->app->basePath()
        ));

        $this->artisan('make:class', ['name' => 'Value/Foo'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Value;',
            'class Foo',
        ], 'app/Value/Foo.php');
    }
}
