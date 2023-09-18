<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;

class CastMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Casts/FooBar.php',
    ];

    /** @test */
    public function it_can_generate_cast_file()
    {
        $this->artisan('make:cast', ['name' => 'FooBar', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Casts;',
            'use Illuminate\Contracts\Database\Eloquent\CastsAttributes;',
            'class FooBar implements CastsAttributes',
            'public function get($model, string $key, $value, array $attributes)',
            'public function set($model, string $key, $value, array $attributes)',
        ], 'app/Casts/FooBar.php');
    }

    /** @test */
    public function it_can_generate_inbound_cast_file()
    {
        $this->artisan('make:cast', ['name' => 'FooBar', '--inbound' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Casts;',
            'use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;',
            'class FooBar implements CastsInboundAttributes',
            'public function set($model, string $key, $value, array $attributes)',
        ], 'app/Casts/FooBar.php');
    }
}
