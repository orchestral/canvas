<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ViewMakeCommandTest extends TestCase
{
    protected $files = [
        'resources/views/foo.blade.php',
        'tests/Feature/View/FooTest.php',
    ];

    #[Test]
    public function it_can_generate_feature_view_file()
    {
        $this->artisan('make:view', ['name' => 'foo', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFilenameExists('resources/views/foo.blade.php');
        $this->assertFilenameNotExists('tests/Feature/View/FooTest.php');
    }

    #[Test]
    public function it_can_generate_feature_view_file_with_tests()
    {
        $this->artisan('make:view', ['name' => 'foo', '--test' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFilenameExists('resources/views/foo.blade.php');

        $this->assertFileContains([
            'namespace Tests\Feature\View;',
            'use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;',
            'use Tests\TestCase;',
            'class FooTest extends TestCase',
            'use InteractsWithViews;',
        ], 'tests/Feature/View/FooTest.php');
    }
}
