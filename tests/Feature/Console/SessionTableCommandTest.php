<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Console\SessionTableCommand;
use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class SessionTableCommandTest extends TestCase
{
    #[Test]
    public function it_can_generate_migration_file()
    {
        $this->artisan(SessionTableCommand::class, ['--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
            'Schema::create(\'sessions\', function (Blueprint $table) {',
        ], 'create_sessions_table.php');
    }
}
