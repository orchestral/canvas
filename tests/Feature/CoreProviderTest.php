<?php

namespace Orchestra\Canvas\Tests\Feature;

use Orchestra\Canvas\Core\CommandProvider;
use Orchestra\Testbench\TestCase;

class CommandProviderTest extends TestCase
{
    use CommandProvider;

    /** @test */
    public function it_can_setup_laravel_preset()
    {
        $directory = $this->getBasePath();
        $preset = $this->presetForLaravel($this->app);

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
}
