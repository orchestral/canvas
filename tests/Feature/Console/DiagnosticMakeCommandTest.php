<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Console\DiagnosticMakeCommand;
use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class DiagnosticMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Diagnostics/FooIsAvailable.php',
    ];

    #[Test]
    public function it_can_generate_diagnostic_file()
    {
        $this->artisan('make:diagnostic', ['name' => 'FooIsAvailable', '--preset' => 'canvas'])
            ->expectsQuestion('Should the diagnostic offer a fix?', false)
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Diagnostics;',
            'use Laravel\Doctor\Diagnostic;',
            'use Laravel\Doctor\Results\DiagnosticResult;',
            'use Laravel\Doctor\Results\Message;',
            'class FooIsAvailable extends Diagnostic',
        ], 'app/Diagnostics/FooIsAvailable.php');
    }


    #[Test]
    public function it_can_generate_fixable_diagnostic_file()
    {
        $this->artisan('make:diagnostic', ['name' => 'FooIsAvailable', '--preset' => 'canvas'])
            ->expectsQuestion('Should the diagnostic offer a fix?', true)
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Diagnostics;',
            'use Laravel\Doctor\Contracts\Fixable;',
            'use Laravel\Doctor\Diagnostic;',
            'use Laravel\Doctor\Results\DiagnosticResult;',
            'use Laravel\Doctor\Results\Message;',
            'class FooIsAvailable extends Diagnostic implements Fixable',
        ], 'app/Diagnostics/FooIsAvailable.php');
    }
}
