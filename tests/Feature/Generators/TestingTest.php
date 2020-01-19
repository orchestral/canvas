<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

use Orchestra\Canvas\Core\Presets\Laravel;
use Orchestra\Canvas\Core\Presets\Package;

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
    public function it_can_generate_unit_test_file_on_laravel_preset_with_different_testcase()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'testing' => ['namespace' => 'Tests', 'extends' => ['unit' => 'Tests\UnitTestCase']]], $this->app->basePath(), $this->filesystem
        ));

        $this->artisan('make:test', ['name' => 'FooTest', '--unit' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace Tests\Unit;',
            'use Tests\UnitTestCase;',
            'class FooTest extends UnitTestCase',
        ], 'tests/Unit/FooTest.php');
    }


    /** @test */
    public function it_can_generate_feature_test_file_on_laravel_preset_with_different_testcase()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'testing' => ['namespace' => 'Tests', 'extends' => ['feature' => 'Tests\FeatureTestCase']]], $this->app->basePath(), $this->filesystem
        ));

        $this->artisan('make:test', ['name' => 'FooTest'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace Tests\Feature;',
            'use Illuminate\Foundation\Testing\RefreshDatabase;',
            'use Tests\FeatureTestCase;',
            'class FooTest extends FeatureTestCase',
        ], 'tests/Feature/FooTest.php');
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

    /** @test */
    public function it_can_generate_unit_test_file_on_package_preset_with_different_testcase()
    {
        $this->instance('orchestra.canvas', new Package(
            ['namespace' => 'Foo', 'testing' => ['namespace' => 'Foo\Tests', 'extends' => ['unit' => 'Foo\Tests\UnitTestCase']]], $this->app->basePath(), $this->filesystem
        ));

        $this->artisan('make:test', ['name' => 'FooTest', '--unit' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace Foo\Tests\Unit;',
            'use Foo\Tests\UnitTestCase;',
            'class FooTest extends UnitTestCase',
        ], 'tests/Unit/FooTest.php');
    }


    /** @test */
    public function it_can_generate_feature_test_file_on_package_preset_with_different_testcase()
    {
        $this->instance('orchestra.canvas', new Package(
            ['namespace' => 'Foo', 'testing' => ['namespace' => 'Foo\Tests', 'extends' => ['feature' => 'Foo\Tests\FeatureTestCase']]], $this->app->basePath(), $this->filesystem
        ));

        $this->artisan('make:test', ['name' => 'FooTest'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace Foo\Tests\Feature;',
            'use Illuminate\Foundation\Testing\RefreshDatabase;',
            'use Foo\Tests\FeatureTestCase;',
            'class FooTest extends FeatureTestCase',
        ], 'tests/Feature/FooTest.php');
    }
}
