<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ConsoleMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Console/Commands/FooCommand.php',
    ];

    #[Test]
    public function it_can_generate_command_file()
    {
        $this->artisan('make:command', ['name' => 'FooCommand', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Console\Commands;',
            'use Illuminate\Console\Command;',
            '#[Signature(\'app:foo-command\')]',
            'class FooCommand extends Command',
        ], 'app/Console/Commands/FooCommand.php');
    }

    #[Test]
    public function it_can_generate_command_file_with_command_name()
    {
        $this->artisan('make:command', ['name' => 'FooCommand', '--command' => 'foo:bar', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Console\Commands;',
            'use Illuminate\Console\Command;',
            '#[Signature(\'foo:bar\')]',
            'class FooCommand extends Command',
        ], 'app/Console/Commands/FooCommand.php');
    }
}
