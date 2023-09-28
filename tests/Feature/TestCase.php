<?php

namespace Orchestra\Canvas\Tests\Feature;

use Orchestra\Testbench\Concerns\InteractsWithPublishedFiles;
use Orchestra\Testbench\Concerns\WithWorkbench;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use InteractsWithPublishedFiles;
    use WithWorkbench;
}
