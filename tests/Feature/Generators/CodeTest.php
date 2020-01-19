<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

use Orchestra\Canvas\Core\Presets\Laravel;

class CodeTest extends TestCase
{
    protected $files = [
        'app/Value/Foo.php',
    ];

    /** @test */
    public function it_can_generate_class_file()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'generators' => ['Orchestra\Canvas\Commands\Code']], $this->app->basePath(), $this->filesystem
        ));

        $this->artisan('make:class', ['name' => 'Value/Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Value;',
            'class Foo',
        ], 'app/Value/Foo.php');
    }

    /** @test */
    public function it_cant_generate_class_file()
    {
        $this->expectException('Symfony\Component\Console\Exception\CommandNotFoundException');
        $this->expectExceptionMessage('The command "make:class" does not exist.');

        $this->artisan('make:class', ['name' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Value;',
            'class Foo',
        ], 'app/Value/Foo.php');
    }
}
