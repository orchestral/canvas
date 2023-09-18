<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

class RequestTest extends TestCase
{
    protected $files = [
        'app/Http/Requests/FooRequest.php',
    ];

    /** @test */
    public function it_can_generate_request_file()
    {
        $this->artisan('make:request', ['name' => 'FooRequest'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Http\Requests;',
            'use Illuminate\Foundation\Http\FormRequest;',
            'class FooRequest extends FormRequest',
        ], 'app/Http/Requests/FooRequest.php');
    }
}
