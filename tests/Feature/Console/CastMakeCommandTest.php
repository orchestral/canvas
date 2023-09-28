<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;

class CastMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Casts/Foo.php',
    ];

    public function testItCanGenerateCastFile()
    {
        $this->artisan('make:cast', ['name' => 'FooBar', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Casts;',
            'use Illuminate\Contracts\Database\Eloquent\CastsAttributes;',
            'class Foo implements CastsAttributes',
            'public function get(Model $model, string $key, mixed $value, array $attributes): mixed',
            'public function set(Model $model, string $key, mixed $value, array $attributes): mixed',
        ], 'app/Casts/Foo.php');
    }

    public function testItCanGenerateInboundCastFile()
    {
        $this->artisan('make:cast', ['name' => 'FooBar', '--inbound' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Casts;',
            'use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;',
            'class Foo implements CastsInboundAttributes',
            'public function set(Model $model, string $key, mixed $value, array $attributes): mixed',
        ], 'app/Casts/Foo.php');
    }
}
