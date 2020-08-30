<?php

namespace Orchestra\Canvas\Tests\Feature\Generators\Routing;

use Orchestra\Canvas\Core\Presets\Laravel;
use Orchestra\Canvas\Tests\Feature\Generators\TestCase;

class ControllerTest extends TestCase
{
    protected $files = [
        'app/Http/Controllers/FooController.php',
    ];

    /** @test */
    public function it_can_generate_controller_file()
    {
        $this->artisan('make:controller', ['name' => 'FooController'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController extends Controller',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'public function __invoke(Request $request)',
        ], 'app/Http/Controllers/FooController.php');
    }

    /** @test */
    public function it_can_generate_controller_with_invokable_options_file()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--invokable' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController extends Controller',
            'public function __invoke(Request $request)',
        ], 'app/Http/Controllers/FooController.php');
    }

    /** @test */
    public function it_can_generate_controller_with_model_options_file()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--model' => 'Foo', '--no-interaction' => true])
            ->assertExitCode(0);

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

    /** @test */
    public function it_can_generate_controller_with_model_with_parent_options_file()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--model' => 'Bar', '--parent' => 'Foo', '--no-interaction' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use App\Http\Controllers\Controller;',
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

    /** @test */
    public function it_can_generate_controller_with_model_options_file_with_custom_model_namespace()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'App', 'model' => ['namespace' => 'App\Model']], $this->app->basePath(), $this->filesystem
        ));

        $this->artisan('make:controller', ['name' => 'FooController', '--model' => 'Foo', '--no-interaction' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use App\Http\Controllers\Controller;',
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
            ['namespace' => 'App', 'model' => ['namespace' => 'App\Model']], $this->app->basePath(), $this->filesystem
        ));

        $this->artisan('make:controller', ['name' => 'FooController', '--model' => 'Bar', '--parent' => 'Foo', '--no-interaction' => true])
            ->assertExitCode(0);

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
        $this->artisan('make:controller', ['name' => 'FooController', '--api' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController extends Controller',
            'public function index()',
            'public function store(Request $request)',
            'public function update(Request $request, $id)',
            'public function destroy($id)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'public function create()',
            'public function edit($id)',
        ], 'app/Http/Controllers/FooController.php');
    }

    /** @test */
    public function it_can_generate_controller_file_can_handle_invokable_options_ignores_api()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--api' => true, '--invokable' => true])
            ->assertExitCode(0);

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

    /** @test */
    public function it_can_generate_controller_with_model_and_api_options_file()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--model' => 'Foo', '--api' => true, '--no-interaction' => true])
            ->assertExitCode(0);

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
}
