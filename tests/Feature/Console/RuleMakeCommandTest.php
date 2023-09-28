<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;

class RuleMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Rules/Foo.php',
    ];

    public function testItCanGenerateRuleFile()
    {
        $this->artisan('make:rule', ['name' => 'FooBar', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Rules;',
            'use Illuminate\Contracts\Validation\ValidationRule;',
            'class Foo implements ValidationRule',
        ], 'app/Rules/Foo.php');
    }

    public function testItCanGenerateInvokableRuleFile()
    {
        $this->artisan('make:rule', ['name' => 'FooBar', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Rules;',
            'use Illuminate\Contracts\Validation\ValidationRule;',
            'class Foo implements ValidationRule',
            'public function validate(string $attribute, mixed $value, Closure $fail): void',
        ], 'app/Rules/Foo.php');
    }

    public function testItCanGenerateImplicitRuleFile()
    {
        $this->artisan('make:rule', ['name' => 'FooBar', '--implicit' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Rules;',
            'use Illuminate\Contracts\Validation\ValidationRule;',
            'class Foo implements ValidationRule',
            'public $implicit = true;',
            'public function validate(string $attribute, mixed $value, Closure $fail): void',
        ], 'app/Rules/Foo.php');
    }
}
