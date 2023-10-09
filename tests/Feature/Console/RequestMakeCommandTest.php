<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;

class RequestMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Http/Requests/FooRequest.php',
    ];

    /** @test */
    public function it_can_generate_request_file()
    {
        $this->artisan('make:request', ['name' => 'FooRequest', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Http\Requests;',
            'use Illuminate\Foundation\Http\FormRequest;',
            'class FooRequest extends FormRequest',
        ], 'app/Http/Requests/FooRequest.php');
    }
}
