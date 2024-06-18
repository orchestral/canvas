<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UserModelMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Models/User.php',
    ];

    #[Test]
    public function it_can_generate_broadcasting_channel_file()
    {
        $this->artisan('make:user-model', ['--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Foundation\Auth\User as Authenticatable;',
            'class User extends Authenticatable',
            'use HasFactory, Notifiable;',
        ], 'app/Models/User.php');
    }
}
