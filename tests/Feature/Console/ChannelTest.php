<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;

class ChannelTest extends TestCase
{
    protected $files = [
        'app/Broadcasting/FooChannel.php',
    ];

    /** @test */
    public function it_can_generate_broadcasting_channel_file()
    {
        $this->artisan('make:channel', ['name' => 'FooChannel', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Broadcasting;',
            'use Illuminate\Foundation\Auth\User;',
            'class FooChannel',
        ], 'app/Broadcasting/FooChannel.php');
    }
}
