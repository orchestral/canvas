<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;

class SessionTableCommandTest extends TestCase
{
    /** @test */
    public function it_can_generate_migration_file()
    {
        $this->artisan('session:table', ['--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
            'Schema::create(\'sessions\', function (Blueprint $table) {',
        ], 'create_sessions_table.php');
    }
}
