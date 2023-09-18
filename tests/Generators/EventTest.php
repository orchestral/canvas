<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

class EventTest extends TestCase
{
    protected $files = [
        'app/Events/FooCreated.php',
    ];

    /** @test */
    public function it_can_generate_event_file()
    {
        $this->artisan('make:event', ['name' => 'FooCreated'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Events;',
            'class FooCreated',
        ], 'app/Events/FooCreated.php');
    }
}
