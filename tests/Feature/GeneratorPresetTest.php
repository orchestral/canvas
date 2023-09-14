<?php

namespace Orchestra\Canvas\Tests;

use Illuminate\Console\Generators\PresetManager;
use Illuminate\Console\Generators\Presets\Preset;
use Orchestra\Canvas\Presets\Package;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;

class GeneratorPresetTest extends TestCase
{
    use WithWorkbench;

    /** @test */
    public function it_can_be_resolved_and_has_correct_signature_as_laravel_preset()
    {
        $workingPath = realpath(__DIR__.'/../../vendor/orchestra/testbench-core/laravel');

        $preset = $this->app[PresetManager::class]->driver('canvas');

        $this->assertInstanceOf(Preset::class, $preset);
        $this->assertSame('canvas', $preset->name());

        $this->assertSame("{$workingPath}", $preset->basePath());
        $this->assertSame("{$workingPath}/app", $preset->sourcePath());
        $this->assertSame("{$workingPath}/resources", $preset->resourcePath());
        $this->assertSame("{$workingPath}/resources/views", $preset->viewPath());
        $this->assertSame("{$workingPath}/database/factories", $preset->factoryPath());
        $this->assertSame("{$workingPath}/database/migrations", $preset->migrationPath());
        $this->assertSame("{$workingPath}/database/seeders", $preset->seederPath());

        $this->assertSame('App\\', $preset->rootNamespace());
        $this->assertSame('App\Console\Commands\\', $preset->commandNamespace());
        $this->assertSame('App\Models\\', $preset->modelNamespace());
        $this->assertSame('App\Providers\\', $preset->providerNamespace());
        $this->assertSame('Database\Factories\\', $preset->factoryNamespace());
        $this->assertSame('Database\Seeders\\', $preset->seederNamespace());

        $this->assertTrue($preset->hasCustomStubPath());
        $this->assertSame('Illuminate\Foundation\Auth\User', $preset->userProviderModel());
    }

    /** @test */
    public function it_can_be_resolved_and_has_correct_signature_as_package_preset()
    {
        $workingPath = \dirname(__DIR__, 2);

        $this->instance('orchestra.canvas', $this->resolveCanvasPreset($workingPath));

        $preset = $this->app[PresetManager::class]->driver('canvas');

        $this->assertInstanceOf(Preset::class, $preset);
        $this->assertSame('canvas', $preset->name());

        $this->assertSame("{$workingPath}", $preset->basePath());
        $this->assertSame("{$workingPath}/src", $preset->sourcePath());
        $this->assertSame("{$workingPath}/resources", $preset->resourcePath());
        $this->assertSame("{$workingPath}/resources/views", $preset->viewPath());
        $this->assertSame("{$workingPath}/database/factories", $preset->factoryPath());
        $this->assertSame("{$workingPath}/database/migrations", $preset->migrationPath());
        $this->assertSame("{$workingPath}/database/seeders", $preset->seederPath());

        $this->assertSame('Acme\\', $preset->rootNamespace());
        $this->assertSame('Acme\Console\\', $preset->commandNamespace());
        $this->assertSame('Acme\\', $preset->modelNamespace());
        $this->assertSame('Acme\\', $preset->providerNamespace());
        $this->assertSame('Database\Factories\\', $preset->factoryNamespace());
        $this->assertSame('Database\Seeders\\', $preset->seederNamespace());

        $this->assertFalse($preset->hasCustomStubPath());
        $this->assertSame('Illuminate\Foundation\Auth\User', $preset->userProviderModel());
    }

    protected function resolveCanvasPreset($workingPath): Package
    {
        return new Package(
            basePath: $workingPath,
            config: [
                'namespace' => 'Acme',
                'path' => ['src' => 'src/'],
            ],
        );
    }
}
