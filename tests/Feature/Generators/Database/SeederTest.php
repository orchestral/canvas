<?php

namespace Orchestra\Canvas\Tests\Feature\Generators\Database;

use Orchestra\Canvas\Tests\Feature\Generators\TestCase;

class SeederTest extends TestCase
{
    protected $files = [
        'database/seeds/FooSeeder.php',
    ];

    /** @test */
    public function it_can_generate_seeder_file()
    {
        $this->artisan('make:seeder', ['name' => 'FooSeeder'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'use Illuminate\Database\Seeder;',
            'class FooSeeder extends Seeder',
            'public function run()',
        ], 'database/seeds/FooSeeder.php');


        $this->assertFileNotContains([
            'namespace',
        ], 'database/seeds/FooSeeder.php');
    }
}
