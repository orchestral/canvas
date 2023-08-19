<?php

namespace Orchestra\Canvas\Presets;

use Orchestra\Canvas\Core\Presets\Preset;
use Orchestra\Workbench\Workbench;

class PackageWorkbench extends Preset
{
    /**
     * Preset name.
     */
    public function name(): string
    {
        return 'workbench';
    }

    /**
     * Get the path to the base working directory.
     */
    public function laravelPath(): string
    {
        return Workbench::laravelPath();
    }

    /**
     * Get the path to the source directory.
     */
    public function sourcePath(): string
    {
        return Workbench::path();
    }

    /**
     * Preset namespace.
     */
    public function rootNamespace(): string
    {
        return 'Workbench\App';
    }

    /**
     * Model namespace.
     */
    public function modelNamespace(): string
    {
        return 'Workbench\App\Models';
    }

    /**
     * Provider namespace.
     */
    public function providerNamespace(): string
    {
        return 'Workbench\App\Providers';
    }

    /**
     * Get the path to the resource directory.
     */
    public function resourcePath(): string
    {
        return Workbench::path('resources');
    }

    /**
     * Get the path to the factory directory.
     */
    public function factoryPath(): string
    {
        return Workbench::path('database/factories');
    }

    /**
     * Get the path to the migration directory.
     */
    public function migrationPath(): string
    {
        return Workbench::path('database/migrations');
    }

    /**
     * Get the path to the seeder directory.
     */
    public function seederPath(): string
    {
        return Workbench::path('database/seeders');
    }

    /**
     * Get custom stub path.
     */
    public function getCustomStubPath(): ?string
    {
        return null;
    }
}
