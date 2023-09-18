<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

use Orchestra\Canvas\Tests\Feature\TestCase;

class ResourceMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Http/Resources/FooResource.php',
    ];

    /** @test */
    public function it_can_generate_resource_file()
    {
        $this->artisan('make:resource', ['name' => 'FooResource', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Resources;',
            'use Illuminate\Http\Request;',
            'use Illuminate\Http\Resources\Json\JsonResource;',
            'class FooResource extends JsonResource',
            'public function toArray(Request $request)',
        ], 'app/Http/Resources/FooResource.php');
    }

    /** @test */
    public function it_can_generate_resource_collection_file()
    {
        $this->artisan('make:resource', ['name' => 'FooResource', '--collection' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Resources;',
            'use Illuminate\Http\Request;',
            'use Illuminate\Http\Resources\Json\ResourceCollection;',
            'class FooResource extends ResourceCollection',
            'public function toArray(Request $request)',
        ], 'app/Http/Resources/FooResource.php');
    }
}
