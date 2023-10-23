<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RequestMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Http/Requests/FooRequest.php',
    ];

    #[Test]
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
