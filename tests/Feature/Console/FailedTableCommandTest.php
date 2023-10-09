<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;

class FailedTableCommandTest extends TestCase
{
    /** @test */
    public function it_can_generate_migration_file()
    {
        $this->artisan('queue:failed-table', ['--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
            'Schema::create(\'failed_jobs\', function (Blueprint $table) {',
        ], 'create_failed_jobs_table.php');
    }
}
