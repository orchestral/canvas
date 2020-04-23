<?php

namespace Orchestra\Canvas\Tests\Feature\Generators\Database;

use Orchestra\Canvas\Tests\Feature\Generators\TestCase;

class FactoryTest extends TestCase
{
    protected $files = [
        'database/factories/FooFactory.php',
    ];

    /** @test */
    public function it_can_generate_factory_file()
    {
        $this->artisan('make:factory', ['name' => 'FooFactory'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace Database\Factories;',
            'use App\Model;',
            'use Illuminate\Database\Eloquent\Factories\Factory;',
            'class ModelFactory extends Factory',
            'protected $model = Model::class;',
            'public function definition()',
        ], 'database/factories/FooFactory.php');
    }

    /** @test */
    public function it_can_generate_factory_with_model_file()
    {
        $this->artisan('make:factory', ['name' => 'FooFactory', '--model' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace Database\Factories;',
            'use App\Foo;',
            'use Illuminate\Database\Eloquent\Factories\Factory;',
            'class FooFactory extends Factory',
            'protected $model = Foo::class;',
            'public function definition()',
        ], 'database/factories/FooFactory.php');
    }
}
