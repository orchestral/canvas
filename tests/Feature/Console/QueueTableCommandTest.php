<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class QueueTableCommandTest extends TestCase
{
    #[Test]
    public function it_can_generate_migration_file()
    {
        $this->artisan('queue:table', ['--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
            'Schema::create(\'jobs\', function (Blueprint $table) {',
        ], 'create_jobs_table.php');
    }
}
