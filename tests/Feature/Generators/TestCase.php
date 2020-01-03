<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
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
        $this->cleanUpMigrationFiles();
    }

    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        $this->cleanUpFiles();
        $this->cleanUpMigrationFiles();

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

    /**
     * Assert file does contains data.
     */
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

    /**
     * Assert file doesn't contains data.
     */
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

    /**
     * Assert file does contains data.
     */
    protected function assertMigrationFileContains(array $contains, string $file, string $message = ''): void
    {
        $haystack = $this->filesystem->get($this->getMigrationFile($file));

        foreach ($contains as $needle) {
            $this->assertStringContainsString($needle, $haystack, $message);
        }
    }

    /**
     * Assert file doesn't contains data.
     */
    protected function assertMigrationFileNotContains(array $contains, string $file, string $message = ''): void
    {
        $haystack = $this->filesystem->get($this->getMigrationFile($file));

        foreach ($contains as $needle) {
            $this->assertStringNotContainsString($needle, $haystack, $message);
        }
    }


    /**
     * Assert filename exists.
     */
    protected function assertFilenameExists(string $file): void
    {
        $appFile = $this->app->basePath($file);

        $this->assertTrue($this->filesystem->exists($appFile), "Assert file {$file} does exist");
    }

    /**
     * Assert filename not exists.
     */
    protected function assertFilenameNotExists(string $file): void
    {
        $appFile = $this->app->basePath($file);

        $this->assertTrue(! $this->filesystem->exists($appFile), "Assert file {$file} doesn't exist");
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

    /**
     * Removes generated migration files.
     */
    protected function getMigrationFile(string $filename): string
    {
        $migrationPath = $this->app->databasePath('migrations');

        return $this->filesystem->glob("{$migrationPath}/*{$filename}")[0];
    }

    /**
     * Removes generated migration files.
     */
    protected function cleanUpMigrationFiles(): void
    {
        $this->filesystem->delete(
            Collection::make($this->filesystem->files($this->app->databasePath('migrations')))
                ->filter(function ($file) {
                    return Str::endsWith($file, '.php');
                })->all()
        );
    }
}
