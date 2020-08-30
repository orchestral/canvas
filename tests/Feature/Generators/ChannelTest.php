<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

class ChannelTest extends TestCase
{
    protected $files = [
        'app/Broadcasting/FooChannel.php',
    ];

    /** @test */
    public function it_can_generate_broadcasting_channel_file()
    {
        $this->artisan('make:channel', ['name' => 'FooChannel'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Broadcasting;',
            'use App\Models\User;',
            'class FooChannel',
        ], 'app/Broadcasting/FooChannel.php');
    }
}
