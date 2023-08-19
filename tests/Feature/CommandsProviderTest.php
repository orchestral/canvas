<?php

namespace Orchestra\Canvas\Tests\Feature;

use Orchestra\Canvas\Core\CommandsProvider;
use Orchestra\Testbench\TestCase;

class CommandsProviderTest extends TestCase
{
    use CommandsProvider;

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
        $this->assertSame('App\Models', $preset->modelNamespace());
        $this->assertSame('App\Providers', $preset->providerNamespace());

        $this->assertSame("{$directory}/app", $preset->sourcePath());
        $this->assertSame("{$directory}/resources", $preset->resourcePath());
        $this->assertSame("{$directory}/database/factories", $preset->factoryPath());
        $this->assertSame("{$directory}/database/migrations", $preset->migrationPath());
        $this->assertSame("{$directory}/database/seeders", $preset->seederPath());
    }
}
