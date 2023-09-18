<?php

namespace Illuminate\Tests\Integration\Generators;

class CastMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Casts/Foo.php',
    ];

    public function testItCanGenerateCastFile()
    {
        $this->artisan('make:cast', ['name' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Casts;',
            'use Illuminate\Contracts\Database\Eloquent\CastsAttributes;',
            'class Foo implements CastsAttributes',
            'public function get($model, string $key, $value, array $attributes)',
            'public function set($model, string $key, $value, array $attributes)',
        ], 'app/Casts/Foo.php');
    }

    public function testItCanGenerateInboundCastFile()
    {
        $this->artisan('make:cast', ['name' => 'Foo', '--inbound' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Casts;',
            'use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;',
            'class Foo implements CastsInboundAttributes',
            'public function set($model, string $key, $value, array $attributes)',
        ], 'app/Casts/Foo.php');
    }
}
