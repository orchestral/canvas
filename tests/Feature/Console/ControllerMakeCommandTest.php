<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Presets\Laravel;
use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ControllerMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Http/Controllers/FooController.php',
        'app/Http/Requests/StoreFooRequest.php',
        'app/Http/Requests/UpdateFooRequest.php',
        'tests/Feature/Http/Controllers/FooControllerTest.php',
    ];

    #[Test]
    public function it_can_generate_controller_file()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'public function __invoke(Request $request)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFilenameNotExists('tests/Feature/Http/Controllers/FooControllerTest.php');
    }

    #[Test]
    public function it_can_generate_controller_file_with_specific_type()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--type' => 'invokable', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController',
            'public function __invoke(Request $request)',
        ], 'app/Http/Controllers/FooController.php');
    }

    #[Test]
    public function it_can_generate_controller_with_invokable_options_file()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--invokable' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController',
            'public function __invoke(Request $request)',
        ], 'app/Http/Controllers/FooController.php');
    }

    #[Test]
    public function it_can_generate_controller_with_model_options_file()
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

    #[Test]
    public function it_can_generate_controller_with_model_with_parent_options_file()
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

    #[Test]
    public function it_can_generate_controller_with_model_options_file_with_custom_model_namespace()
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

    #[Test]
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

    #[Test]
    public function it_can_generate_controller_with_api_options_file()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--api' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController',
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

    #[Test]
    public function it_can_generate_controller_file_can_handle_invokable_options_ignores_api()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--api' => true, '--invokable' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController',
            'public function __invoke(Request $request)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'public function index()',
            'public function store(Request $request)',
            'public function update(Request $request, $id)',
            'public function destroy($id)',
        ], 'app/Http/Controllers/FooController.php');
    }

    #[Test]
    public function it_can_generate_controller_with_model_and_api_options_file()
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

    #[Test]
    public function it_can_generate_controller_file_with_tests()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--test' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFilenameExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameExists('tests/Feature/Http/Controllers/FooControllerTest.php');
    }

    /** @test */
    public function it_can_generate_controller_with_model_and_requests()
    {
        $this->artisan('make:controller', ['name' => 'FooController', '--model' => 'Foo', '--requests' => true, '--preset' => 'canvas'])
            ->expectsQuestion('A App\Models\Foo model does not exist. Do you want to generate it?', false)
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use App\Models\Foo;',
            'use App\Http\Requests\StoreFooRequest;',
            'use App\Http\Requests\UpdateFooRequest;',
            'public function index()',
            'public function create()',
            'public function store(StoreFooRequest $request)',
            'public function show(Foo $foo)',
            'public function edit(Foo $foo)',
            'public function update(UpdateFooRequest $request, Foo $foo)',
            'public function destroy(Foo $foo)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFilenameExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameExists('app/Http/Requests/StoreFooRequest.php');
        $this->assertFilenameExists('app/Http/Requests/UpdateFooRequest.php');
    }

    /** @test */
    public function it_can_generate_controller_with_model_and_requests_with_custom_preset()
    {
        $this->instance('orchestra.canvas', new Laravel(
            ['namespace' => 'Acme', 'model' => ['namespace' => 'Acme\Models']], $this->app->basePath()
        ));

        $this->artisan('make:controller', ['name' => 'FooController', '--model' => 'Foo', '--requests' => true, '--preset' => 'canvas'])
            ->expectsQuestion('A Acme\Models\Foo model does not exist. Do you want to generate it?', false)
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace Acme\Http\Controllers;',
            'use Acme\Models\Foo;',
            'use Acme\Http\Requests\StoreFooRequest;',
            'use Acme\Http\Requests\UpdateFooRequest;',
            'public function index()',
            'public function create()',
            'public function store(StoreFooRequest $request)',
            'public function show(Foo $foo)',
            'public function edit(Foo $foo)',
            'public function update(UpdateFooRequest $request, Foo $foo)',
            'public function destroy(Foo $foo)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFilenameExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameExists('app/Http/Requests/StoreFooRequest.php');
        $this->assertFilenameExists('app/Http/Requests/UpdateFooRequest.php');
    }
}
