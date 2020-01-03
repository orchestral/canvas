<?php

namespace Orchestra\Canvas\Tests;

use Illuminate\Filesystem\Filesystem;
use Orchestra\Canvas\Canvas;
use PHPUnit\Framework\TestCase;

class CanvasTest extends TestCase
{
    /** @test */
    public function it_can_setup_laravel_preset()
    {
        $files = new Filesystem();
        $preset = Canvas::preset([
            'preset' => 'laravel',
        ], __DIR__, $files);

        $this->assertInstanceOf('Orchestra\Canvas\Presets\Laravel', $preset);
    }

    /** @test */
    public function it_can_setup_package_preset()
    {
        $files = new Filesystem();
        $preset = Canvas::preset([
            'preset' => 'package',
        ], __DIR__, $files);

        $this->assertInstanceOf('Orchestra\Canvas\Presets\Package', $preset);
    }
}
