<?php

namespace Orchestra\Canvas\Concerns;

use Orchestra\Canvas\Core\Presets\Preset;

trait ResolvesPresetStubs
{

    /**
     * Get the stub file for the preset, or return null.
     */
    public function getStubFileFromPresetStorage(Preset $preset, string $filename): ?string
    {
        $directory = $this->getPresetStorage();

        if ($preset->name() !== 'laravel') {
            if (\file_exists("{$directory}/{$preset->name()}/$filename")) {
                return "{$directory}/{$preset->name()}/$filename";
            }
        }

        return "{$directory}/laravel/$filename";
    }

    /**
     * Get the stub storage.
     */
    public function getPresetStorage(): string
    {
        return __DIR__.'/../../storage';
    }
}
