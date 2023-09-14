<?php

namespace Orchestra\Canvas\Tests\Feature;

use Orchestra\Testbench\Concerns\InteractsWithPublishedFiles;
use Orchestra\Testbench\Concerns\WithWorkbench;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use InteractsWithPublishedFiles, WithWorkbench;
}
