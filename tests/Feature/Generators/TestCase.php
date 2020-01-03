<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Assert;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Stubs files.
     *
     * @var array
     */
    protected $files = [];

    /**
     * The filesystem implementation.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->filesystem = $this->app['files'];

        $this->cleanUpFiles();
    }

    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        $this->cleanUpFiles();

        parent::tearDown();

        unset($this->filesystem);
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Orchestra\Canvas\LaravelServiceProvider::class,
        ];
    }

    protected function assertFileContains(array $contains, string $file, string $message = ''): void
    {
        $this->assertFilenameExists($file);

        $haystack = $this->filesystem->get(
            $this->app->basePath($file)
        );

        foreach ($contains as $needle) {
            $this->assertStringContainsString($needle, $haystack, $message);
        }
    }

    protected function assertFileNotContains(array $contains, string $file, string $message = ''): void
    {
        $this->assertFilenameExists($file);

        $haystack = $this->filesystem->get(
            $this->app->basePath($file)
        );

        foreach ($contains as $needle) {
            $this->assertStringNotContainsString($needle, $haystack, $message);
        }
    }

    protected function assertFilenameExists(string $file): void
    {
        $appFile = $this->app->basePath($file);

        if (! $this->filesystem->exists($appFile)) {
            $this->assertFalse($appFile, "Unable to find asserted file {$file}");
        }
    }

    /**
     * Removes generated files.
     */
    protected function cleanUpFiles(): void
    {
        $this->filesystem->delete(
            Collection::make($this->files)
                ->transform(function ($file) {
                    return $this->app->basePath($file);
                })
                ->filter(function ($file) {
                    return $this->filesystem->exists($file);
                })->all()
        );
    }
}
