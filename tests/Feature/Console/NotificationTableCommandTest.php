<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Console\NotificationTableCommand;
use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class NotificationTableCommandTest extends TestCase
{
    #[Test]
    public function it_can_generate_migration_file()
    {
        $this->artisan(NotificationTableCommand::class, ['--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'return new class extends Migration',
            'Schema::create(\'notifications\', function (Blueprint $table) {',
        ], 'create_notifications_table.php');
    }
}
