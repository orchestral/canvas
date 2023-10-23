<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Presets\Laravel;
use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PolicyMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Policies/FooPolicy.php',
    ];

    #[Test]
    public function it_can_generate_policy_file()
    {
        $this->artisan('make:policy', ['name' => 'FooPolicy', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Policies;',
            'use Illuminate\Foundation\Auth\User;',
            'class FooPolicy',
        ], 'app/Policies/FooPolicy.php');
    }

    #[Test]
    public function it_can_generate_policy_with_model_options_file()
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

    #[Test]
    public function it_can_generate_policy_with_model_options_file_with_custom_model_namespace()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'model' => ['namespace' => 'App\Model'], 'user-auth-model' => 'App\Models\User'], $this->app->basePath()
        ));

        $this->artisan('make:policy', ['name' => 'FooPolicy', '--model' => 'Post', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Policies;',
            'use App\Model\Post;',
            'use App\Models\User;',
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
