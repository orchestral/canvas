<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;

class ResourceMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Http/Resources/FooResource.php',
        'app/Http/Resources/FooResourceCollection.php',
    ];

    /** @test */
    public function it_can_generate_resource_file()
    {
        $this->artisan('make:resource', ['name' => 'FooResource', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Resources;',
            'use Illuminate\Http\Resources\Json\JsonResource;',
            'class FooResource extends JsonResource',
        ], 'app/Http/Resources/FooResource.php');
    }

    /** @test */
    public function it_can_generate_resource_collection_file()
    {
        $this->artisan('make:resource', ['name' => 'FooResourceCollection', '--collection' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Resources;',
            'use Illuminate\Http\Resources\Json\ResourceCollection;',
            'class FooResourceCollection extends ResourceCollection',
        ], 'app/Http/Resources/FooResourceCollection.php');
    }
}
