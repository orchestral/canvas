<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;

class UserModelMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Models/User.php',
    ];

    /** @test */
    public function it_can_generate_broadcasting_channel_file()
    {
        $this->artisan('make:user-model', ['--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Foundation\Auth\User as Authenticatable;',
            'class User extends Authenticatable',
        ], 'app/Models/User.php');
    }
}
