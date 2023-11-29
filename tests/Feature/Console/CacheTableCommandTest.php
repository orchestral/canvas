<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Console\CacheTableCommand;
use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CacheTableCommandTest extends TestCase
{
    #[Test]
    public function it_can_generate_migration_file()
    {
        $this->artisan(CacheTableCommand::class, ['--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
            'Schema::create(\'cache\', function (Blueprint $table) {',
            'Schema::create(\'cache_locks\', function (Blueprint $table) {',
            'Schema::dropIfExists(\'cache\');',
            'Schema::dropIfExists(\'cache_locks\');',
        ], 'create_cache_table.php');
    }
}
