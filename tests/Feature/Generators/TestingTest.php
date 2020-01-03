<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

use Orchestra\Canvas\Presets\Package;

class TestingTest extends TestCase
{
    protected $files = [
        'tests/Feature/FooTest.php',
        'tests/Unit/FooTest.php',
    ];

    /** @test */
    public function it_can_generate_feature_test_file()
    {
        $this->artisan('make:test', ['name' => 'FooTest'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace Tests\Feature;',
            'use Illuminate\Foundation\Testing\RefreshDatabase;',
            'use Illuminate\Foundation\Testing\WithFaker;',
            'use Tests\TestCase;',
            'class FooTest extends TestCase',
        ], 'tests/Feature/FooTest.php');
    }

    /** @test */
    public function it_can_generate_unit_test_file()
    {
        $this->artisan('make:test', ['name' => 'FooTest', '--unit' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace Tests\Unit;',
            'use PHPUnit\Framework\TestCase;',
            'class FooTest extends TestCase',
        ], 'tests/Unit/FooTest.php');
    }

    /** @test */
    public function it_can_generate_feature_test_file_on_package_preset()
    {
        $this->instance('orchestra.canvas', new Package(
            ['namespace' => 'Foo', 'testing' => ['namespace' => 'Foo\Tests']], $this->app->basePath(), $this->filesystem
        ));

        $this->artisan('make:test', ['name' => 'FooTest'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace Foo\Tests\Feature;',
            'use Illuminate\Foundation\Testing\RefreshDatabase;',
            'use Orchestra\Testbench\TestCase;',
            'class FooTest extends TestCase',
        ], 'tests/Feature/FooTest.php');
    }
}
