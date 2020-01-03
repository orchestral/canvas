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
            'use App\Model;',
            'use Faker\Generator as Faker;',
            '$factory->define(Model::class, function (Faker $faker) {',
        ], 'database/factories/FooFactory.php');

        $this->assertFileNotContains([
            'namespace',
        ], 'database/factories/FooFactory.php');
    }


    /** @test */
    public function it_can_generate_factory_with_model_file()
    {
        $this->artisan('make:factory', ['name' => 'FooFactory', '--model' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'use App\Foo;',
            'use Faker\Generator as Faker;',
            '$factory->define(Foo::class, function (Faker $faker) {',
        ], 'database/factories/FooFactory.php');

        $this->assertFileNotContains([
            'namespace',
        ], 'database/factories/FooFactory.php');
    }
}
