<?php

namespace Orchestra\Canvas\Tests\Feature;

use Orchestra\Canvas\Core\PresetManager;
use Orchestra\Canvas\Core\Presets\Preset;
use Orchestra\Canvas\Presets\Package;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;

use function Illuminate\Filesystem\join_paths;

class GeneratorPresetTest extends TestCase
{
    use WithWorkbench;

    #[Test]
    public function it_can_be_resolved_and_has_correct_signature_as_laravel_preset()
    {
        $workingPath = realpath(join_paths(__DIR__, '..', '..', 'vendor', 'orchestra', 'testbench-core', 'laravel'));

        $preset = $this->app[PresetManager::class]->driver('canvas');

        $this->assertInstanceOf(Preset::class, $preset);
        $this->assertSame('canvas', $preset->name());

        $this->assertSame($workingPath, $preset->basePath());
        $this->assertSame(join_paths($workingPath, 'app'), $preset->sourcePath());
        $this->assertSame(join_paths($workingPath, 'resources'), $preset->resourcePath());
        $this->assertSame(join_paths($workingPath, 'resources', 'views'), $preset->viewPath());
        $this->assertSame(join_paths($workingPath, 'database', 'factories'), $preset->factoryPath());
        $this->assertSame(join_paths($workingPath, 'database', 'migrations'), $preset->migrationPath());
        $this->assertSame(join_paths($workingPath, 'database', 'seeders'), $preset->seederPath());

        $this->assertSame('App\\', $preset->rootNamespace());
        $this->assertSame('App\Console\Commands\\', $preset->commandNamespace());
        $this->assertSame('App\Models\\', $preset->modelNamespace());
        $this->assertSame('App\Providers\\', $preset->providerNamespace());
        $this->assertSame('Database\Factories\\', $preset->factoryNamespace());
        $this->assertSame('Database\Seeders\\', $preset->seederNamespace());

        $this->assertTrue($preset->hasCustomStubPath());
        $this->assertSame('Illuminate\Foundation\Auth\User', $preset->userProviderModel());
    }

    #[Test]
    public function it_can_be_resolved_and_has_correct_signature_as_package_preset()
    {
        $workingPath = \dirname(__DIR__, 2);

        $this->instance('orchestra.canvas', $this->resolveCanvasPreset($workingPath));

        $preset = $this->app[PresetManager::class]->driver('canvas');

        $this->assertInstanceOf(Preset::class, $preset);
        $this->assertSame('canvas', $preset->name());

        $this->assertSame($workingPath, $preset->basePath());
        $this->assertSame(join_paths($workingPath, 'src'), $preset->sourcePath());
        $this->assertSame(join_paths($workingPath, 'resources'), $preset->resourcePath());
        $this->assertSame(join_paths($workingPath, 'resources', 'views'), $preset->viewPath());
        $this->assertSame(join_paths($workingPath, 'database', 'factories'), $preset->factoryPath());
        $this->assertSame(join_paths($workingPath, 'database', 'migrations'), $preset->migrationPath());
        $this->assertSame(join_paths($workingPath, 'database', 'seeders'), $preset->seederPath());

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
