<?php

namespace Illuminate\Tests\Integration\Generators;

class ScopeMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Models/Scopes/FooScope.php',
    ];

    public function testItCanGenerateScopeFile()
    {
        $this->artisan('make:scope', ['name' => 'FooScope'])
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
