<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Console\BatchesTableCommand;
use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class BatchesTableCommandTest extends TestCase
{
    #[Test]
    public function it_can_generate_migration_file()
    {
        $this->artisan(BatchesTableCommand::class, ['--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
            'Schema::create(\'job_batches\', function (Blueprint $table) {',
        ], 'create_job_batches_table.php');
    }
}
