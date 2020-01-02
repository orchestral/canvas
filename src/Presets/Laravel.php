<?php

namespace Laravie\Canvas\Presets;

class Laravel extends Preset
{
    /**
     * Preset name.
     */
    public function getName(): string
    {
        return 'laravel';
    }

    /**
     * Get the path to the migration directory.
     */
    public function getMigrationPath(): string;
    {
        return \sprintf('%s/database/migrations', $this->getBasePath());
    }
}
