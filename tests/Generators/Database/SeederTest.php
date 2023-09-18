<?php

namespace Orchestra\Canvas\Tests\Feature\Generators\Database;

use Orchestra\Canvas\Tests\Feature\Generators\TestCase;

class SeederTest extends TestCase
{
    protected $files = [
        'database/seeders/FooSeeder.php',
    ];

    /** @test */
    public function it_can_generate_seeder_file()
    {
        $this->artisan('make:seeder', ['name' => 'FooSeeder'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace Database\Seeders;',
            'use Illuminate\Database\Seeder;',
            'class FooSeeder extends Seeder',
            'public function run()',
        ], 'database/seeders/FooSeeder.php');
    }
}
