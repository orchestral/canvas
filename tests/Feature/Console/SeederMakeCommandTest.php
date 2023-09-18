<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;

class SeederMakeCommandTest extends TestCase
{
    protected $files = [
        'database/seeders/FooSeeder.php',
    ];

    /** @test */
    public function it_can_generate_seeder_file()
    {
        $this->artisan('make:seeder', ['name' => 'FooSeeder', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace Database\Seeders;',
            'use Illuminate\Database\Seeder;',
            'class FooSeeder extends Seeder',
            'public function run()',
        ], 'database/seeders/FooSeeder.php');
    }
}
