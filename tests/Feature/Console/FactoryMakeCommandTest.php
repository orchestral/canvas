<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Presets\Laravel;
use Orchestra\Canvas\Tests\Feature\TestCase;

class FactoryMakeCommandTest extends TestCase
{
    protected $files = [
        'database/factories/FooFactory.php',
    ];

    /** @test */
    public function it_can_generate_factory_file()
    {
        $this->artisan('make:factory', ['name' => 'FooFactory', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace Database\Factories;',
            'use App\Models\Model;',
            'use Illuminate\Database\Eloquent\Factories\Factory;',
            'class FooFactory extends Factory',
            'protected $model = Model::class;',
            'public function definition()',
        ], 'database/factories/FooFactory.php');
    }

    /** @test */
    public function it_can_generate_factory_with_model_file()
    {
        $this->artisan('make:factory', ['name' => 'FooFactory', '--model' => 'Foo', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace Database\Factories;',
            'use App\Models\Foo;',
            'use Illuminate\Database\Eloquent\Factories\Factory;',
            'class FooFactory extends Factory',
            'protected $model = Foo::class;',
            'public function definition()',
        ], 'database/factories/FooFactory.php');
    }

    /** @test */
    public function it_can_generate_factory_file_with_custom_preset()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'Acme', 'factory' => ['namespace' => 'Acme\Database\Factory']], $this->app->basePath()
        ));

        $this->artisan('make:factory', ['name' => 'FooFactory', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace Acme\Database\Factory;',
            'use Acme\Models\Model;',
            'use Illuminate\Database\Eloquent\Factories\Factory;',
            'class FooFactory extends Factory',
            'protected $model = Model::class;',
            'public function definition()',
        ], 'database/factories/FooFactory.php');
    }

    /** @test */
    public function it_can_generate_factory_with_model_file_with_custom_preset()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'Acme', 'factory' => ['namespace' => 'Acme\Database\Factory']], $this->app->basePath()
        ));

        $this->artisan('make:factory', ['name' => 'FooFactory', '--model' => 'Foo', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace Acme\Database\Factory;',
            'use Acme\Models\Foo;',
            'use Illuminate\Database\Eloquent\Factories\Factory;',
            'class FooFactory extends Factory',
            'protected $model = Foo::class;',
            'public function definition()',
        ], 'database/factories/FooFactory.php');
    }
}
