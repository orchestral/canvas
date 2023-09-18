<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;

class EventMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Events/FooCreated.php',
    ];

    /** @test */
    public function it_can_generate_event_file()
    {
        $this->artisan('make:event', ['name' => 'FooCreated', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Events;',
            'class FooCreated',
        ], 'app/Events/FooCreated.php');
    }
}
