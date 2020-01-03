<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

class ExceptionTest extends TestCase
{
    protected $files = [
        'app/Exceptions/FooException.php',
    ];

    /** @test */
    public function it_can_generate_exception_file()
    {
        $this->artisan('make:exception', ['name' => 'FooException'])
            ->assertExitCode(0);

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


    /** @test */
    public function it_can_generate_exception_file_with_only_report_options()
    {
        $this->artisan('make:exception', ['name' => 'FooException', '--report' => true])
            ->assertExitCode(0);

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

    /** @test */
    public function it_can_generate_exception_file_with_only_render_options()
    {
        $this->artisan('make:exception', ['name' => 'FooException', '--render' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Exceptions;',
            'use Exception;',
            'class FooException extends Exception',
            'public function render($request)',
        ], 'app/Exceptions/FooException.php');

        $this->assertFileNotContains([
            'public function report()',
        ], 'app/Exceptions/FooException.php');
    }


    /** @test */
    public function it_can_generate_exception_file_with_report_and_render_options()
    {
        $this->artisan('make:exception', ['name' => 'FooException', '--report' => true, '--render' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Exceptions;',
            'use Exception;',
            'class FooException extends Exception',
            'public function render($request)',
            'public function report()',
        ], 'app/Exceptions/FooException.php');
    }
}
