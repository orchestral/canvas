<?php

namespace Laravie\Canvas\Database;

use Laravie\Canvas\Presets\Preset;

class MigrationCreator extends \Illuminate\Database\Migrations\MigrationCreator
{
    /**
     * Canvas preset.
     *
     * @var \Laravie\Canvas\Presets\Preset
     */
    protected $preset;

    /**
     * Create a new migration creator instance.
     */
    public function __construct(Preset $preset)
    {
        $this->files = $preset->getFilesystem();
        $this->preset = $preset;
    }

    /**
     * Get the path to the stubs.
     *
     * @return string
     */
    public function stubPath(): string
    {
        return __DIR__.'/../../storage/database/migrations';
    }
}
