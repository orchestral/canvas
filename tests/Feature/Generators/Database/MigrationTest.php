<?php

namespace Orchestra\Canvas\Tests\Feature\Generators\Database;

use Orchestra\Canvas\Tests\Feature\Generators\TestCase;

class MigrationTest extends TestCase
{
    /** @test */
    public function it_can_generate_migration_file()
    {
        $this->artisan('make:migration', ['name' => 'AddBarToFoosTable'])
            ->assertExitCode(0);

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'class AddBarToFoosTable extends Migration',
            'Schema::table(\'foos\', function (Blueprint $table) {',
        ], 'add_bar_to_foos_table.php');
    }


    /** @test */
    public function it_can_generate_migration_with_table_options_file()
    {
        $this->artisan('make:migration', ['name' => 'AddBarToFoosTable', '--table' => 'foobar'])
            ->assertExitCode(0);

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'class AddBarToFoosTable extends Migration',
            'Schema::table(\'foobar\', function (Blueprint $table) {',
        ], 'add_bar_to_foos_table.php');
    }


    /** @test */
    public function it_can_generate_migration_for_create_using_keyword_file()
    {
        $this->artisan('make:migration', ['name' => 'CreateFoosTable'])
            ->assertExitCode(0);

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'class CreateFoosTable extends Migration',
            'Schema::create(\'foos\', function (Blueprint $table) {',
            'Schema::dropIfExists(\'foos\');',
        ], 'create_foos_table.php');
    }

    /** @test */
    public function it_can_generate_migration_with_create_options_file()
    {
        $this->artisan('make:migration', ['name' => 'FoosTable', '--create' => 'foobar'])
            ->assertExitCode(0);

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'class FoosTable extends Migration',
            'Schema::create(\'foobar\', function (Blueprint $table) {',
            'Schema::dropIfExists(\'foobar\');',
        ], 'foos_table.php');
    }
}
