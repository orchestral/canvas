<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Presets\Laravel;
use Orchestra\Canvas\Tests\Feature\TestCase;

class PolicyMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Policies/FooPolicy.php',
    ];

    public function testItCanGeneratePolicyFile()
    {
        $this->artisan('make:policy', ['name' => 'FooPolicy', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Policies;',
            'use Illuminate\Foundation\Auth\User;',
            'class FooPolicy',
        ], 'app/Policies/FooPolicy.php');
    }

    public function testItCanGeneratePolicyFileWithModelOption()
    {
        $this->artisan('make:policy', ['name' => 'FooPolicy', '--model' => 'Post', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Policies;',
            'use App\Models\Post;',
            'use Illuminate\Foundation\Auth\User;',
            'class FooPolicy',
            'public function viewAny(User $user)',
            'public function view(User $user, Post $post)',
            'public function create(User $user)',
            'public function update(User $user, Post $post)',
            'public function delete(User $user, Post $post)',
            'public function restore(User $user, Post $post)',
            'public function forceDelete(User $user, Post $post)',
        ], 'app/Policies/FooPolicy.php');
    }

    public function testItCanGeneratePolicyFileWithModelOptionWithCustomNamespace()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'model' => ['namespace' => 'App\Model'], 'user-auth-model' => 'App\Models\User'], $this->app->basePath()
        ));

        $this->artisan('make:policy', ['name' => 'FooPolicy', '--model' => 'Post', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Policies;',
            'use Acme\Model\Post;',
            'use Illuminate\Foundation\Auth\User;',
            'class FooPolicy',
            'public function viewAny(User $user)',
            'public function view(User $user, Post $post)',
            'public function create(User $user)',
            'public function update(User $user, Post $post)',
            'public function delete(User $user, Post $post)',
            'public function restore(User $user, Post $post)',
            'public function forceDelete(User $user, Post $post)',
        ], 'app/Policies/FooPolicy.php');
    }
}
