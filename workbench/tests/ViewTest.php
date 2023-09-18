<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

class ViewMakeCommand
{
    protected $files = [
        'resources/views/foo.blade.php',
        'tests/Feature/View/FooTest.php',
    ];

    /** @test */
    public function it_can_generate_feature_view_file()
    {
        $this->artisan('make:view', ['name' => 'foo'])
            ->assertExitCode(0);

        $this->assertFilenameExists('resources/views/foo.blade.php');
        $this->assertFilenameNotExists('tests/Feature/View/FooTest.php');
    }

    /** @test */
    public function it_can_generate_feature_view_file_with_tests()
    {
        $this->artisan('make:view', ['name' => 'foo', '--test' => true])
            ->assertExitCode(0);

        $this->assertFilenameExists('resources/views/foo.blade.php');
        $this->assertFilenameExists('tests/Feature/View/FooTest.php');
    }
}
