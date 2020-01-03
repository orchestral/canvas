<?php

namespace Orchestra\Canvas\Tests\Feature\Generators\Database;

use Orchestra\Canvas\Tests\Feature\Generators\TestCase;

class ObserverTest extends TestCase
{
    protected $files = [
        'app/Observers/FooObserver.php',
    ];

    /** @test */
    public function it_can_generate_observer_file()
    {
        $this->artisan('make:observer', ['name' => 'FooObserver'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Observers;',
            'class FooObserver',
        ], 'app/Observers/FooObserver.php');
    }


    /** @test */
    public function it_can_generate_observer_with_model_file()
    {
        $this->artisan('make:observer', ['name' => 'FooObserver', '--model' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Observers;',
            'use App\Foo;',
            'class FooObserver',
            'public function created(Foo $foo)',
            'public function updated(Foo $foo)',
            'public function deleted(Foo $foo)',
            'public function restored(Foo $foo)',
            'public function forceDeleted(Foo $foo)',
        ], 'app/Observers/FooObserver.php');
    }
}
