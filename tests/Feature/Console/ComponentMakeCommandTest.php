<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ComponentMakeCommandTest extends TestCase
{
    protected $files = [
        'app/View/Components/Foo.php',
        'resources/views/components/foo.blade.php',
    ];

    #[Test]
    public function it_can_generate_component_file()
    {
        $this->artisan('make:component', ['name' => 'Foo', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\View\Components;',
            'use Illuminate\View\Component;',
            'class Foo extends Component',
            "return view('components.foo');",
        ], 'app/View/Components/Foo.php');

        $this->assertFilenameExists('resources/views/components/foo.blade.php');
    }

    #[Test]
    public function it_can_generate_component_file_with_view()
    {
        $this->artisan('make:component', ['name' => 'Foo', '--view' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\View\Components;',
            'use Illuminate\View\Component;',
            'class Foo extends Component',
            "return view('components.foo');",
        ], 'app/View/Components/Foo.php');

        $this->assertFilenameExists('resources/views/components/foo.blade.php');
    }

    #[Test]
    public function it_can_generate_inline_component_file()
    {
        $this->artisan('make:component', ['name' => 'Foo', '--inline' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\View\Components;',
            'use Illuminate\View\Component;',
            'class Foo extends Component',
            "return <<<'blade'",
        ], 'app/View/Components/Foo.php');

        $this->assertFilenameNotExists('resources/views/components/foo.blade.php');
    }
}
