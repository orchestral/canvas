<?php

namespace Orchestra\Canvas\Tests\Feature\Presets;

use Illuminate\Filesystem\Filesystem;
use Orchestra\Canvas\Presets\PackageWorkbench;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;

use function Orchestra\Testbench\package_path;
use function Orchestra\Testbench\workbench_path;

class PackageWorkbenchTest extends TestCase
{
    use WithWorkbench;

    /** @test */
    public function it_has_proper_signatures()
    {
        $directory = rtrim(package_path(), DIRECTORY_SEPARATOR);
        $preset = new PackageWorkbench([], $directory, $files = new Filesystem());

        $this->assertSame('workbench', $preset->name());
        $this->assertSame([], $preset->config());
        $this->assertTrue($preset->is('workbench'));
        $this->assertFalse($preset->is('package'));
        $this->assertFalse($preset->is('laravel'));

        $this->assertSame($directory, $preset->basePath());
        $this->assertSame($this->app->basePath(), $preset->laravelPath());

        $this->assertSame('Workbench\App', $preset->rootNamespace());
        $this->assertSame('Workbench\App\Models', $preset->modelNamespace());
        $this->assertSame('Workbench\App\Providers', $preset->providerNamespace());
        $this->assertSame('Workbench\Database\Factories', $preset->factoryNamespace());
        $this->assertSame('Workbench\Database\Seeders', $preset->seederNamespace());

        $this->assertSame(workbench_path('app'), $preset->sourcePath());
        $this->assertSame("{$directory}/vendor", $preset->vendorPath());
        $this->assertSame(workbench_path('resources'), $preset->resourcePath());
        $this->assertSame(workbench_path('database/factories'), $preset->factoryPath());
        $this->assertSame(workbench_path('database/migrations'), $preset->migrationPath());
        $this->assertSame(workbench_path('database/seeders'), $preset->seederPath());

        $this->assertFalse($preset->hasCustomStubPath());
        $this->assertNull($preset->getCustomStubPath());

        $this->assertSame($files, $preset->filesystem());
    }

    public static function normalisePath(string $path): string
    {
        return str_replace('/', DIRECTORY_SEPARATOR, $path);
    }
}
