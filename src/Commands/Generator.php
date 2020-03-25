<?php

namespace Orchestra\Canvas\Commands;

use Orchestra\Canvas\Concerns\ResolvesPresetStubs;

abstract class Generator extends \Orchestra\Canvas\Core\Commands\Generator
{
    use ResolvesPresetStubs;
}
