<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Presets\Laravel;
use Orchestra\Canvas\Tests\Feature\TestCase;

class ObserverMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Observers/FooObserver.php',
    ];

    public function testItCanGenerateObserverFile()
    {
        $this->artisan('make:observer', ['name' => 'FooObserver', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Observers;',
            'class FooObserver',
        ], 'app/Observers/FooObserver.php');
    }

    public function testItCanGenerateObserverFileWithModel()
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

    public function testItCanGenerateObserverFileWithCustomNamespacedModel()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'model' => ['namespace' => 'App\Model']], $this->app->basePath()
        ));

        $this->artisan('make:observer', ['name' => 'FooObserver', '--model' => 'Foo', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Observers;',
            'use Acme\Model\Foo;',
            'class FooObserver',
            'public function created(Foo $foo)',
            'public function updated(Foo $foo)',
            'public function deleted(Foo $foo)',
            'public function restored(Foo $foo)',
            'public function forceDeleted(Foo $foo)',
        ], 'app/Observers/FooObserver.php');
    }
}
