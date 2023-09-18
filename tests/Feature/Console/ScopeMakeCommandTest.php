<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;

class ScopeMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Models/Scopes/FooScope.php',
    ];

    /** @test */
    public function it_can_generate_scope_file()
    {
        $this->artisan('make:scope', ['name' => 'FooScope', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Models\Scopes;',
            'use Illuminate\Database\Eloquent\Builder;',
            'use Illuminate\Database\Eloquent\Model;',
            'use Illuminate\Database\Eloquent\Scope;',
            'class FooScope implements Scope',
        ], 'app/Models/Scopes/FooScope.php');
    }
}
