<?php

namespace Orchestra\Canvas\Tests\Unit\Presets;

use Mockery as m;
use Orchestra\Canvas\Presets\Laravel;
use PHPUnit\Framework\TestCase;

class LaravelTest extends TestCase
{
    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function it_has_proper_signatures()
    {
        $directory = __DIR__;
        $preset = new Laravel([], $directory);

        $this->assertSame('laravel', $preset->name());
        $this->assertSame([], $preset->config());
        $this->assertTrue($preset->is('laravel'));
        $this->assertFalse($preset->is('package'));

        $this->assertSame($directory, $preset->basePath());

        $this->assertSame('App', $preset->rootNamespace());
        $this->assertSame('Tests', $preset->testingNamespace());
        $this->assertSame('App\Models', $preset->modelNamespace());
        $this->assertSame('App\Providers', $preset->providerNamespace());
        $this->assertSame('Database\Factories', $preset->factoryNamespace());
        $this->assertSame('Database\Seeders', $preset->seederNamespace());

        $this->assertSame("{$directory}/app", $preset->sourcePath());
        $this->assertSame("{$directory}/vendor", $preset->vendorPath());
        $this->assertSame("{$directory}/resources", $preset->resourcePath());
        $this->assertSame("{$directory}/database/factories", $preset->factoryPath());
        $this->assertSame("{$directory}/database/migrations", $preset->migrationPath());
        $this->assertSame("{$directory}/database/seeders", $preset->seederPath());

        $this->assertSame("{$directory}/stubs", $preset->getCustomStubPath());
    }

    /** @test */
    public function it_can_configure_model_namespace()
    {
        $directory = __DIR__;
        $preset = new Laravel(['namespace' => 'App', 'model' => ['namespace' => 'App\Model']], $directory);

        $this->assertSame('App', $preset->rootNamespace());
        $this->assertSame('App\Model', $preset->modelNamespace());
        $this->assertSame('App\Providers', $preset->providerNamespace());
    }

    /** @test */
    public function it_can_configure_provider_namespace()
    {
        $directory = __DIR__;
        $preset = new Laravel(['namespace' => 'App', 'provider' => ['namespace' => 'App']], $directory);

        $this->assertSame('App', $preset->rootNamespace());
        $this->assertSame('App\Models', $preset->modelNamespace());
        $this->assertSame('App', $preset->providerNamespace());
    }
}
