<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Presets\Laravel;
use Orchestra\Canvas\Tests\Feature\TestCase;

class ObserverMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Observers/FooObserver.php',
    ];

    /** @test */
    public function it_can_generate_observer_file()
    {
        $this->artisan('make:observer', ['name' => 'FooObserver', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Observers;',
            'class FooObserver',
        ], 'app/Observers/FooObserver.php');
    }

    /** @test */
    public function it_can_generate_observer_with_model_file()
    {
        $this->artisan('make:observer', ['name' => 'FooObserver', '--model' => 'Foo', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Observers;',
            'use App\Models\Foo;',
            'class FooObserver',
            'public function created(Foo $foo)',
            'public function updated(Foo $foo)',
            'public function deleted(Foo $foo)',
            'public function restored(Foo $foo)',
            'public function forceDeleted(Foo $foo)',
        ], 'app/Observers/FooObserver.php');
    }

    /** @test */
    public function it_can_generate_observer_with_model_file_with_custom_model_namespace()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'model' => ['namespace' => 'App\Model']], $this->app->basePath()
        ));

        $this->artisan('make:observer', ['name' => 'FooObserver', '--model' => 'Foo', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Observers;',
            'use App\Model\Foo;',
            'class FooObserver',
            'public function created(Foo $foo)',
            'public function updated(Foo $foo)',
            'public function deleted(Foo $foo)',
            'public function restored(Foo $foo)',
            'public function forceDeleted(Foo $foo)',
        ], 'app/Observers/FooObserver.php');
    }
}
