<?php

namespace Orchestra\Canvas\Tests\Feature\Generators\Database;

use Orchestra\Canvas\Tests\Feature\Generators\TestCase;

class EloquentTest extends TestCase
{
    protected $files = [
        'app/Models/Foo.php',
        'app/Models/Foo/Bar.php',
        'app/Http/Controllers/FooController.php',
        'app/Http/Controllers/BarController.php',
        'database/factories/FooFactory.php',
        'database/seeders/FooSeeder.php',
    ];

    /** @test */
    public function it_can_generate_eloquent_file()
    {
        $this->artisan('make:model', ['name' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Models/Foo.php');
    }

    /** @test */
    public function it_can_generate_eloquent_with_pivot_options_file()
    {
        $this->artisan('make:model', ['name' => 'Foo', '--pivot' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Relations\Pivot;',
            'class Foo extends Pivot',
        ], 'app/Models/Foo.php');
    }

    /** @test */
    public function it_can_generate_eloquent_with_controller_options_file()
    {
        $this->artisan('make:model', ['name' => 'Foo', '--controller' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Models/Foo.php');

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class FooController extends Controller',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFileNotContains([
            'use App\Models\Foo;',
            'public function index()',
            'public function create()',
            'public function store(Request $request)',
            'public function show(Foo $foo)',
            'public function edit(Foo $foo)',
            'public function update(Request $request, Foo $foo)',
            'public function destroy(Foo $foo)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFilenameNotExists('database/factories/FooFactory.php');
        $this->assertFilenameNotExists('database/seeders/FooSeeder.php');
    }

    /** @test */
    public function it_can_generate_eloquent_with_resource_controller_options_file()
    {
        $this->artisan('make:model', ['name' => 'Foo', '--resource' => true, '--no-interaction' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Models/Foo.php');

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use App\Models\Foo;',
            'use Illuminate\Http\Request;',
            'class FooController extends Controller',
            'public function index()',
            'public function create()',
            'public function store(Request $request)',
            'public function show(Foo $foo)',
            'public function edit(Foo $foo)',
            'public function update(Request $request, Foo $foo)',
            'public function destroy(Foo $foo)',
        ], 'app/Http/Controllers/FooController.php');

        $this->assertFilenameNotExists('database/factories/FooFactory.php');
        $this->assertFilenameNotExists('database/seeders/FooSeeder.php');
    }

    /** @test */
    public function it_can_generate_eloquent_with_factory_options_file()
    {
        $this->artisan('make:model', ['name' => 'Foo', '--factory' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Models/Foo.php');

        $this->assertFilenameNotExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameExists('database/factories/FooFactory.php');
        $this->assertFilenameNotExists('database/seeders/FooSeeder.php');
    }

    /** @test */
    public function it_can_generate_eloquent_with_migration_options_file()
    {
        $this->artisan('make:model', ['name' => 'Foo', '--migration' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Models/Foo.php');

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'class CreateFoosTable extends Migration',
            'Schema::create(\'foos\', function (Blueprint $table) {',
            'Schema::dropIfExists(\'foos\');',
        ], 'create_foos_table.php');

        $this->assertFilenameNotExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameNotExists('database/factories/FooFactory.php');
        $this->assertFilenameNotExists('database/seeders/FooSeeder.php');
    }

    /** @test */
    public function it_can_generate_eloquent_with_seeder_options_file()
    {
        $this->artisan('make:model', ['name' => 'Foo', '--seed' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Models/Foo.php');

        $this->assertFilenameNotExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameNotExists('database/factories/FooFactory.php');
        $this->assertFilenameExists('database/seeders/FooSeeder.php');
    }

    /** @test */
    public function it_can_generate_nested_eloquent_with_controller_options_file()
    {
        $this->artisan('make:model', ['name' => 'Foo/Bar', '--controller' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models\Foo;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Bar extends Model',
        ], 'app/Models/Foo/Bar.php');

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use Illuminate\Http\Request;',
            'class BarController extends Controller',
        ], 'app/Http/Controllers/BarController.php');

        $this->assertFilenameNotExists('database/factories/FooFactory.php');
        $this->assertFilenameNotExists('database/seeders/FooSeeder.php');
    }

    /** @test */
    public function it_can_generate_nested_eloquent_with_resource_controller_options_file()
    {
        $this->artisan('make:model', ['name' => 'Foo/Bar', '--resource' => true, '--no-interaction' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models\Foo;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Bar extends Model',
        ], 'app/Models/Foo/Bar.php');

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use App\Models\Foo\Bar;',
            'use Illuminate\Http\Request;',
            'class BarController extends Controller',
            'public function index()',
            'public function create()',
            'public function store(Request $request)',
            'public function show(Bar $bar)',
            'public function edit(Bar $bar)',
            'public function update(Request $request, Bar $bar)',
            'public function destroy(Bar $bar)',
        ], 'app/Http/Controllers/BarController.php');

        $this->assertFilenameNotExists('database/factories/FooFactory.php');
        $this->assertFilenameNotExists('database/seeders/FooSeeder.php');
    }

    /** @test */
    public function it_can_generate_nested_eloquent_with_api_controller_options_file()
    {
        $this->artisan('make:model', ['name' => 'Foo/Bar', '--api' => true, '--no-interaction' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models\Foo;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Bar extends Model',
        ], 'app/Models/Foo/Bar.php');

        $this->assertFileContains([
            'namespace App\Http\Controllers;',
            'use App\Models\Foo\Bar;',
            'use Illuminate\Http\Request;',
            'class BarController extends Controller',
            'public function index()',
            'public function store(Request $request)',
            'public function show(Bar $bar)',
            'public function update(Request $request, Bar $bar)',
            'public function destroy(Bar $bar)',
        ], 'app/Http/Controllers/BarController.php');

        $this->assertFilenameNotExists('database/factories/FooFactory.php');
        $this->assertFilenameNotExists('database/seeders/FooSeeder.php');
    }

    /** @test */
    public function it_can_generate_eloquent_with_all_options_file()
    {
        $this->artisan('make:model', ['name' => 'Foo', '--all' => true, '--no-interaction' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Models;',
            'use Illuminate\Database\Eloquent\Model;',
            'class Foo extends Model',
        ], 'app/Models/Foo.php');

        $this->assertMigrationFileContains([
            'use Illuminate\Database\Migrations\Migration;',
            'class CreateFoosTable extends Migration',
            'Schema::create(\'foos\', function (Blueprint $table) {',
            'Schema::dropIfExists(\'foos\');',
        ], 'create_foos_table.php');

        $this->assertFilenameExists('app/Http/Controllers/FooController.php');
        $this->assertFilenameExists('database/factories/FooFactory.php');
        $this->assertFilenameExists('database/seeders/FooSeeder.php');
    }
}
