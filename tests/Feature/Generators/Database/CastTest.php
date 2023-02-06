<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

class CastTest extends TestCase
{
    protected $files = [
        'app/Casts/FooBar.php',
    ];

    /** @test */
    public function it_can_generate_cast_file()
    {
        $this->artisan('make:cast', ['name' => 'FooBar'])
            ->assertExitCode(0);

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
        $this->artisan('make:cast', ['name' => 'FooBar', '--inbound' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Casts;',
            'use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;',
            'class FooBar implements CastsInboundAttributes',
            'public function set(Model $model, string $key, mixed $value, array $attributes): mixed',
        ], 'app/Casts/FooBar.php');
    }
}
