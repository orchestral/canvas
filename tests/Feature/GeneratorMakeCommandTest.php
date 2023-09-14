<?php

namespace Orchestra\Canvas\Tests\Feature;

use Orchestra\Canvas\Presets\Laravel;

class GeneratorMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Console/Commands/FooCommand.php',
    ];

    /** @test */
    public function it_can_generate_command_file()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'generators' => ['Orchestra\Canvas\Commands\ConsoleGenerator']], $this->app->basePath()
        ));

        $this->artisan('make:generator', ['name' => 'FooCommand'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Console\Commands;',
            'use Orchestra\Canvas\Commands\Generator;',
            'use Symfony\Component\Console\Attribute\AsCommand;',
            '#[AsCommand(name: \'make:name\', description: \'Create a new class\')]',
            'class FooCommand extends Generator',
        ], 'app/Console/Commands/FooCommand.php');
    }

    /** @test */
    public function it_can_generate_command_file_with_command_name()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'generators' => ['Orchestra\Canvas\Commands\ConsoleGenerator']], $this->app->basePath()
        ));

        $this->artisan('make:generator', ['name' => 'FooCommand', '--command' => 'make:foobar'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Console\Commands;',
            'use Orchestra\Canvas\Commands\Generator;',
            'use Symfony\Component\Console\Attribute\AsCommand;',
            '#[AsCommand(name: \'make:foobar\', description: \'Create a new class\')]',
            'class FooCommand extends Generator',
        ], 'app/Console/Commands/FooCommand.php');
    }

    /** @test */
    public function it_can_generate_command_file_with_command_name_without_make_prefix()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'generators' => ['Orchestra\Canvas\Commands\ConsoleGenerator']], $this->app->basePath()
        ));

        $this->artisan('make:generator', ['name' => 'FooCommand', '--command' => 'foobar'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Console\Commands;',
            'use Orchestra\Canvas\Commands\Generator;',
            'use Symfony\Component\Console\Attribute\AsCommand;',
            '#[AsCommand(name: \'foobar\', description: \'Create a new class\')]',
            'class FooCommand extends Generator',
        ], 'app/Console/Commands/FooCommand.php');
    }
}
