<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Presets\Laravel;
use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class MigrateMakeCommandTest extends TestCase
{
    protected $files = [
        'database/acme-migrations/*.php',
    ];

    #[Test]
    public function it_can_generate_migration_file()
    {
        $this->artisan('make:migration', ['name' => 'AddBarToFoosTable', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
            'Schema::table(\'foos\', function (Blueprint $table) {',
        ], 'add_bar_to_foos_table.php');
    }

    #[Test]
    public function it_can_generate_migration_with_table_options_file()
    {
        $this->artisan('make:migration', ['name' => 'AddBarToFoosTable', '--table' => 'foobar', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
            'Schema::table(\'foobar\', function (Blueprint $table) {',
        ], 'add_bar_to_foos_table.php');
    }

    #[Test]
    public function it_can_generate_migration_for_create_using_keyword_file()
    {
        $this->artisan('make:migration', ['name' => 'CreateFoosTable', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
            'Schema::create(\'foos\', function (Blueprint $table) {',
            'Schema::dropIfExists(\'foos\');',
        ], 'create_foos_table.php');
    }

    #[Test]
    public function it_can_generate_migration_with_create_options_file()
    {
        $this->artisan('make:migration', ['name' => 'FoosTable', '--create' => 'foobar', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
            'Schema::create(\'foobar\', function (Blueprint $table) {',
            'Schema::dropIfExists(\'foobar\');',
        ], 'foos_table.php');
    }

    public function testItCanGenerateMigrationFileWithCustomMigrationPath()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'Acme', 'migration' => ['path' => 'database'.DIRECTORY_SEPARATOR.'acme-migrations']], $this->app->basePath()
        ));

        $this->artisan('make:migration', ['name' => 'AcmeFoosTable', '--create' => 'foobar', '--preset' => 'canvas'])
            ->assertExitCode(0);

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
            'Schema::create(\'foobar\', function (Blueprint $table) {',
            'Schema::dropIfExists(\'foobar\');',
        ], 'acme_foos_table.php', directory: 'database/acme-migrations');
    }
}
