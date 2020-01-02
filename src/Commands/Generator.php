<?php

namespace Laravie\Canvas\Commands;

use Laravie\Canvas\Presets\Preset;
use Symfony\Component\Console\Command\Command;

abstract class Generator extends Command
{
    /**
     * Canvas preset.
     *
     * @var \Laravie\Canvas\Presets\Preset
     */
    protected $preset;

    /**
     * Construct a new generator command.
     */
    public function __construct(Preset $preset)
    {
        $this->preset = $preset;

        parent::__construct();
    }
}
