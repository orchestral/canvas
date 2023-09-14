<?php

namespace Orchestra\Canvas\Tests\Feature;

use Orchestra\Canvas\Presets\Package;
use Orchestra\Canvas\Presets\Laravel;

class TestMakeCommandTest extends TestCase
{
    protected $files = [
        'tests/Feature/FooTest.php',
        'tests/Unit/FooTest.php',
    ];

    /** @test */
    public function it_can_generate_unit_test_file_on_laravel_preset_with_different_testcase()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'testing' => ['namespace' => 'Tests', 'extends' => ['unit' => 'Tests\UnitTestCase']]], $this->app->basePath()
        ));

        $this->artisan('make:test', ['name' => 'FooTest', '--unit' => true, '--preset' => 'canvas'])
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
            ['namespace' => 'App', 'testing' => ['namespace' => 'Tests', 'extends' => ['feature' => 'Tests\FeatureTestCase']]], $this->app->basePath()
        ));

        $this->artisan('make:test', ['name' => 'FooTest', '--preset' => 'canvas'])
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
            ['namespace' => 'Foo', 'testing' => ['namespace' => 'Foo\Tests']], $this->app->basePath()
        ));

        $this->artisan('make:test', ['name' => 'FooTest', '--preset' => 'canvas'])
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
            ['namespace' => 'Foo', 'testing' => ['namespace' => 'Foo\Tests', 'extends' => ['unit' => 'Foo\Tests\UnitTestCase']]], $this->app->basePath()
        ));

        $this->artisan('make:test', ['name' => 'FooTest', '--unit' => true, '--preset' => 'canvas'])
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
            ['namespace' => 'Foo', 'testing' => ['namespace' => 'Foo\Tests', 'extends' => ['feature' => 'Foo\Tests\FeatureTestCase']]], $this->app->basePath()
        ));

        $this->artisan('make:test', ['name' => 'FooTest', '--preset' => 'canvas'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace Foo\Tests\Feature;',
            'use Illuminate\Foundation\Testing\RefreshDatabase;',
            'use Foo\Tests\FeatureTestCase;',
            'class FooTest extends FeatureTestCase',
        ], 'tests/Feature/FooTest.php');
    }

    public function it_can_generate_pest_feature_test_file()
    {
        $this->artisan('make:test', ['name' => 'FooTest', '--pest' => true, '--preset' => 'canvas'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'test(\'example\', function () {',
            '$response = $this->get(\'/\');',
            '$response->assertStatus(200);',
        ], 'tests/Feature/FooTest.php');
    }

    /** @test */
    public function it_can_generate_pest_unit_test_file()
    {
        $this->artisan('make:test', ['name' => 'FooTest', '--unit' => true, '--pest' => true, '--preset' => 'canvas'])
            ->assertExitCode(0);
        $this->assertFileContains([
            'test(\'example\', function () {',
            'expect(true)->toBeTrue();',
        ], 'tests/Unit/FooTest.php');
    }

    /** @test */
    public function it_can_generate_pest_unit_test_file_on_laravel_preset_with_different_testcase()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'testing' => ['namespace' => 'Tests', 'extends' => ['unit' => 'Tests\UnitTestCase']]], $this->app->basePath()
        ));

        $this->artisan('make:test', ['name' => 'FooTest', '--unit' => true, '--pest' => true, '--preset' => 'canvas'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'test(\'example\', function () {',
            'expect(true)->toBeTrue();',
        ], 'tests/Unit/FooTest.php');
    }

    /** @test */
    public function it_can_generate_pest_feature_test_file_on_laravel_preset_with_different_testcase()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'testing' => ['namespace' => 'Tests', 'extends' => ['feature' => 'Tests\FeatureTestCase']]], $this->app->basePath()
        ));

        $this->artisan('make:test', ['name' => 'FooTest', '--pest' => true, '--preset' => 'canvas'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'test(\'example\', function () {',
            '$response = $this->get(\'/\');',
            '$response->assertStatus(200);',
        ], 'tests/Feature/FooTest.php');
    }

    /** @test */
    public function it_can_generate_pest_feature_test_file_on_package_preset()
    {
        $this->instance('orchestra.canvas', new Package(
            ['namespace' => 'Foo', 'testing' => ['namespace' => 'Foo\Tests']], $this->app->basePath()
        ));

        $this->artisan('make:test', ['name' => 'FooTest', '--pest' => true, '--preset' => 'canvas'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'test(\'example\', function () {',
            '$response = $this->get(\'/\');',
            '$response->assertStatus(200);',
        ], 'tests/Feature/FooTest.php');
    }

    /** @test */
    public function it_can_generate_pest_unit_test_file_on_package_preset_with_different_testcase()
    {
        $this->instance('orchestra.canvas', new Package(
            ['namespace' => 'Foo', 'testing' => ['namespace' => 'Foo\Tests', 'extends' => ['unit' => 'Foo\Tests\UnitTestCase']]], $this->app->basePath()
        ));

        $this->artisan('make:test', ['name' => 'FooTest', '--unit' => true, '--pest' => true, '--preset' => 'canvas'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'test(\'example\', function () {',
            'expect(true)->toBeTrue();',
        ], 'tests/Unit/FooTest.php');
    }

    /** @test */
    public function it_can_generate_pest_feature_test_file_on_package_preset_with_different_testcase()
    {
        $this->instance('orchestra.canvas', new Package(
            ['namespace' => 'Foo', 'testing' => ['namespace' => 'Foo\Tests', 'extends' => ['feature' => 'Foo\Tests\FeatureTestCase']]], $this->app->basePath()
        ));

        $this->artisan('make:test', ['name' => 'FooTest', '--pest' => true, '--preset' => 'canvas'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'test(\'example\', function () {',
            '$response = $this->get(\'/\');',
            '$response->assertStatus(200);',
        ], 'tests/Feature/FooTest.php');
    }
}
