<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Presets\Laravel;
use Orchestra\Canvas\Tests\Feature\TestCase;

class ControllerMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Http/Controllers/FooController.php',
        'app/Models/Bar.php',
        'app/Models/Foo.php',
        'tests/Feature/Http/Controllers/FooControllerTest.php',
    ];

    public function testItCanGenerateControllerFile()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController extends Controller',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'public function __invoke(Request $request)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFilenameNotExists('tests/Feature/Http/Controllers/FooControllerTest.php');
    }

    public function testItCanGenerateControllerFileWithInvokableTypeOption()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--type' => 'invokable', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController extends Controller',
            'public function __invoke(Request $request)',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function testItCanGenerateControllerFileWithInvokableOption()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--invokable' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController extends Controller',
            'public function __invoke(Request $request)',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function testItCanGenerateControllerFileWithModelOption()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--model' => 'Foo', '--preset' => 'canvas'])
            ->expectsQuestion('A App\Models\Foo model does not exist. Do you want to generate it?', false)
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use App\Models\Foo;',
            'public function index()',
            'public function create()',
            'public function store(Request $request)',
            'public function show(Foo $foo)',
            'public function edit(Foo $foo)',
            'public function update(Request $request, Foo $foo)',
            'public function destroy(Foo $foo)',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function testItCanGenerateControllerFileWithModelAndParentOption()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--model' => 'Bar', '--parent' => 'Foo', '--preset' => 'canvas'])
            ->expectsQuestion('A App\Models\Foo model does not exist. Do you want to generate it?', false)
            ->expectsQuestion('A App\Models\Bar model does not exist. Do you want to generate it?', false)
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use App\Models\Bar;',
            'use App\Models\Foo;',
            'public function index(Foo $foo)',
            'public function create(Foo $foo)',
            'public function store(Request $request, Foo $foo)',
            'public function show(Foo $foo, Bar $bar)',
            'public function edit(Foo $foo, Bar $bar)',
            'public function update(Request $request, Foo $foo, Bar $bar)',
            'public function destroy(Foo $foo, Bar $bar)',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function testItCanGenerateControllerFileWithModelOptionWithCustomNamespace()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'model' => ['namespace' => 'App\Model']], $this->app->basePath()
        ));

        $this->artisan('make:controller', ['name' => 'FooController', '--model' => 'Foo', '--preset' => 'canvas'])
            ->expectsQuestion('A App\Model\Foo model does not exist. Do you want to generate it?', false)
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use App\Model\Foo;',
            'public function index()',
            'public function create()',
            'public function store(Request $request)',
            'public function show(Foo $foo)',
            'public function edit(Foo $foo)',
            'public function update(Request $request, Foo $foo)',
            'public function destroy(Foo $foo)',
        ], 'app/Http/Controllers/FooController.php');
    }

    /** @test */
    public function it_can_generate_controller_with_model_with_parent_options_file_with_custom_model_namespace()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'model' => ['namespace' => 'App\Model']], $this->app->basePath()
        ));

        $this->artisan('make:controller', ['name' => 'FooController', '--model' => 'Bar', '--parent' => 'Foo', '--preset' => 'canvas'])
            ->expectsQuestion('A App\Model\Foo model does not exist. Do you want to generate it?', false)
            ->expectsQuestion('A App\Model\Bar model does not exist. Do you want to generate it?', false)
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use App\Model\Bar;',
            'use App\Model\Foo;',
            'public function index(Foo $foo)',
            'public function create(Foo $foo)',
            'public function store(Request $request, Foo $foo)',
            'public function show(Foo $foo, Bar $bar)',
            'public function edit(Foo $foo, Bar $bar)',
            'public function update(Request $request, Foo $foo, Bar $bar)',
            'public function destroy(Foo $foo, Bar $bar)',
        ], 'app/Http/Controllers/FooController.php');
    }

    /** @test */
    public function it_can_generate_controller_with_api_options_file()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--api' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController extends Controller',
            'public function index()',
            'public function store(Request $request)',
            'public function update(Request $request, string $id)',
            'public function destroy(string $id)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'public function create()',
            'public function edit($id)',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function testItCanGenerateControllerFileWithInvokableIgnoresApiOption()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--api' => true, '--invokable' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController extends Controller',
            'public function __invoke(Request $request)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'public function index()',
            'public function store(Request $request)',
            'public function update(Request $request, $id)',
            'public function destroy($id)',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function testItCanGenerateControllerFileWithApiAndModelOption()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--model' => 'Foo', '--api' => true, '--preset' => 'canvas'])
            ->expectsQuestion('A App\Models\Foo model does not exist. Do you want to generate it?', false)
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use App\Models\Foo;',
            'public function index()',
            'public function store(Request $request)',
            'public function show(Foo $foo)',
            'public function update(Request $request, Foo $foo)',
            'public function destroy(Foo $foo)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'public function create()',
            'public function edit(Foo $foo)',
        ], 'app/Http/Controllers/FooController.php');
    }

    public function testItCanGenerateControllerFileWithTest()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--test' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFilenameExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameExists('tests/Feature/Http/Controllers/FooControllerTest.php');
    }
}
