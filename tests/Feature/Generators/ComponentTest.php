<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

use Orchestra\Canvas\Core\Presets\Laravel;

class ComponentTest extends TestCase
{
    protected $files = [
        'app/View/Components/Foo.php',
        'resources/views/components/foo.blade.php',
    ];

    /** @test */
    public function it_can_generate_component_file()
    {
        $this->artisan('make:component', ['name' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\View\Components;',
            'use Illuminate\View\Component;',
            'class Foo extends Component',
            "return view('components.foo');",
        ], 'app/View/Components/Foo.php');

        $this->assertFilenameExists('resources/views/components/foo.blade.php');
    }


    /** @test */
    public function it_can_generate_inline_component_file()
    {
        $this->artisan('make:component', ['name' => 'Foo', '--inline' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\View\Components;',
            'use Illuminate\View\Component;',
            'class Foo extends Component',
            "return <<<'blade'",
        ], 'app/View/Components/Foo.php');

        $this->assertFilenameNotExists('resources/views/components/foo.blade.php');
    }
}
