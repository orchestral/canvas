<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

use Orchestra\Canvas\Presets\Laravel;

class ConsoleGeneratorTest extends TestCase
{
    protected $files = [
        'app/Console/Commands/FooCommand.php',
    ];

    /** @test */
    public function it_can_generate_command_file()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'generators' => ['Orchestra\Canvas\Commands\ConsoleGenerator']], $this->app->basePath(), $this->filesystem
        ));

        $this->artisan('make:generator', ['name' => 'FooCommand'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Console\Commands;',
            'use Orchestra\Canvas\Commands\Generator;',
            'class FooCommand extends Generator',
            'protected $signature = \'make:name\';',
        ], 'app/Console/Commands/FooCommand.php');
    }

    /** @test */
    public function it_can_generate_command_file_with_command_name()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'generators' => ['Orchestra\Canvas\Commands\ConsoleGenerator']], $this->app->basePath(), $this->filesystem
        ));

        $this->artisan('make:generator', ['name' => 'FooCommand', '--command' => 'make:foobar'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Console\Commands;',
            'use Orchestra\Canvas\Commands\Generator;',
            'class FooCommand extends Generator',
            'protected $signature = \'make:foobar\';',
        ], 'app/Console/Commands/FooCommand.php');
    }


    /** @test */
    public function it_can_generate_command_file_with_command_name_without_make_prefix()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'generators' => ['Orchestra\Canvas\Commands\ConsoleGenerator']], $this->app->basePath(), $this->filesystem
        ));

        $this->artisan('make:generator', ['name' => 'FooCommand', '--command' => 'foobar'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Console\Commands;',
            'use Orchestra\Canvas\Commands\Generator;',
            'class FooCommand extends Generator',
            'protected $signature = \'make:foobar\';',
        ], 'app/Console/Commands/FooCommand.php');
    }
}
