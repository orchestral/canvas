<?php

namespace Orchestra\Canvas\Tests\Unit\Presets;

use Illuminate\Filesystem\Filesystem;
use Orchestra\Canvas\Presets\Laravel;
use PHPUnit\Framework\TestCase;

class LaravelTest extends TestCase
{
    /** @test */
    public function it_has_proper_signatures()
    {
        $directory = __DIR__;
        $preset = new Laravel([], $directory, new Filesystem());

        $this->assertSame('laravel', $preset->name());
        $this->assertTrue($preset->is('laravel'));
        $this->assertFalse($preset->is('package'));

        $this->assertSame($directory, $preset->basePath());

        $this->assertSame('App', $preset->rootNamespace());
        $this->assertSame('App', $preset->modelNamespace());
        $this->assertSame('App\Providers', $preset->providerNamespace());

        $this->assertSame("{$directory}/app", $preset->sourcePath());
        $this->assertSame("{$directory}/resources", $preset->resourcePath());
        $this->assertSame("{$directory}/database/factories", $preset->factoryPath());
        $this->assertSame("{$directory}/database/migrations", $preset->migrationPath());
        $this->assertSame("{$directory}/database/seeds", $preset->seederPath());
    }

    /** @test */
    public function it_can_configure_model_namespace()
    {
        $directory = __DIR__;
        $preset = new Laravel(['namespace' => 'App', 'model' => ['namespace' => 'App\Model']], $directory, new Filesystem());

        $this->assertSame('App', $preset->rootNamespace());
        $this->assertSame('App\Model', $preset->modelNamespace());
        $this->assertSame('App\Providers', $preset->providerNamespace());
    }

    /** @test */
    public function it_can_configure_provider_namespace()
    {
        $directory = __DIR__;
        $preset = new Laravel(['namespace' => 'App', 'provider' => ['namespace' => 'App']], $directory, new Filesystem());

        $this->assertSame('App', $preset->rootNamespace());
        $this->assertSame('App', $preset->modelNamespace());
        $this->assertSame('App', $preset->providerNamespace());
    }
}
