<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ExceptionMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Exceptions/FooException.php',
    ];

    #[Test]
    public function it_can_generate_exception_file()
    {
        $this->artisan('make:exception', ['name' => 'FooException', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Exceptions;',
            'use Exception;',
            'class FooException extends Exception',
        ], 'app/Exceptions/FooException.php');

        $this->assertFileNotContains([
            'public function report()',
            'public function render($request)',
        ], 'app/Exceptions/FooException.php');
    }

    #[Test]
    public function it_can_generate_exception_file_with_only_report_options()
    {
        $this->artisan('make:exception', ['name' => 'FooException', '--report' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Exceptions;',
            'use Exception;',
            'class FooException extends Exception',
            'public function report()',
        ], 'app/Exceptions/FooException.php');

        $this->assertFileNotContains([
            'public function render($request)',
        ], 'app/Exceptions/FooException.php');
    }

    #[Test]
    public function it_can_generate_exception_file_with_only_render_options()
    {
        $this->artisan('make:exception', ['name' => 'FooException', '--render' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Exceptions;',
            'use Exception;',
            'class FooException extends Exception',
            'public function render(Request $request): Response',
        ], 'app/Exceptions/FooException.php');

        $this->assertFileNotContains([
            'public function report()',
        ], 'app/Exceptions/FooException.php');
    }

    #[Test]
    public function it_can_generate_exception_file_with_report_and_render_options()
    {
        $this->artisan('make:exception', ['name' => 'FooException', '--report' => true, '--render' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Exceptions;',
            'use Exception;',
            'class FooException extends Exception',
            'public function render(Request $request): Response',
            'public function report()',
        ], 'app/Exceptions/FooException.php');
    }
}
