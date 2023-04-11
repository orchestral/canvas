<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

class ListenerTest extends TestCase
{
    protected $files = [
        'app/Listeners/HelloWorld.php',
    ];

    /** @test */
    public function it_can_generate_listener_file()
    {
        $this->artisan('make:listener', ['name' => 'HelloWorld'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Listeners;',
            'class HelloWorld',
            'public function handle(object $event)',
        ], 'app/Listeners/HelloWorld.php');

        $this->assertFileNotContains([
            'class HelloWorld implements ShouldQueue',
        ], 'app/Listeners/HelloWorld.php');
    }

    /** @test */
    public function it_can_generate_listener_for_event_file()
    {
        $this->artisan('make:listener', ['name' => 'HelloWorld', '--event' => 'FooCreated'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Listeners;',
            'use App\Events\FooCreated;',
            'class HelloWorld',
            'public function handle(FooCreated $event)',
        ], 'app/Listeners/HelloWorld.php');
    }

    /** @test */
    public function it_can_generate_listener_for_laravel_event_file()
    {
        $this->artisan('make:listener', ['name' => 'HelloWorld', '--event' => 'Illuminate\Auth\Events\Login'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Listeners;',
            'use Illuminate\Auth\Events\Login;',
            'class HelloWorld',
            'public function handle(Login $event)',
        ], 'app/Listeners/HelloWorld.php');
    }

    /** @test */
    public function it_can_generate_queued_listener_file()
    {
        $this->artisan('make:listener', ['name' => 'HelloWorld', '--queued' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Listeners;',
            'use Illuminate\Contracts\Queue\ShouldQueue;',
            'use Illuminate\Queue\InteractsWithQueue;',
            'class HelloWorld implements ShouldQueue',
            'public function handle(object $event)',
        ], 'app/Listeners/HelloWorld.php');
    }

    /** @test */
    public function it_can_generate_queued_listener_with_event_file()
    {
        $this->artisan('make:listener', ['name' => 'HelloWorld', '--queued' => true, '--event' => 'FooCreated'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Listeners;',
            'use App\Events\FooCreated;',
            'use Illuminate\Contracts\Queue\ShouldQueue;',
            'use Illuminate\Queue\InteractsWithQueue;',
            'class HelloWorld implements ShouldQueue',
            'public function handle(FooCreated $event)',
        ], 'app/Listeners/HelloWorld.php');
    }

    /** @test */
    public function it_can_generate_queued_listener_with_laravel_event_file()
    {
        $this->artisan('make:listener', ['name' => 'HelloWorld', '--queued' => true, '--event' => 'Illuminate\Auth\Events\Login'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Listeners;',
            'use Illuminate\Auth\Events\Login;',
            'use Illuminate\Contracts\Queue\ShouldQueue;',
            'use Illuminate\Queue\InteractsWithQueue;',
            'class HelloWorld implements ShouldQueue',
            'public function handle(Login $event)',
        ], 'app/Listeners/HelloWorld.php');
    }
}
