<?php

namespace Orchestra\Canvas\Tests\Feature\Console;

use Orchestra\Canvas\Tests\Feature\TestCase;

class RuleMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Rules/FooBar.php',
    ];

    /** @test */
    public function it_can_generate_rule_file()
    {
        $this->artisan('make:rule', ['name' => 'FooBar', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Rules;',
            'use Illuminate\Contracts\Validation\ValidationRule;',
            'class FooBar implements ValidationRule',
        ], 'app/Rules/FooBar.php');
    }

    /** @test */
    public function it_can_generate_invokable_rule_file()
    {
        $this->artisan('make:rule', ['name' => 'FooBar', '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Rules;',
            'use Illuminate\Contracts\Validation\ValidationRule;',
            'class FooBar implements ValidationRule',
            'public function validate(string $attribute, mixed $value, Closure $fail): void',
        ], 'app/Rules/FooBar.php');
    }

    /** @test */
    public function it_can_generate_invokable_implicit_rule_file()
    {
        $this->artisan('make:rule', ['name' => 'FooBar', '--implicit' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Rules;',
            'use Illuminate\Contracts\Validation\ValidationRule;',
            'class FooBar implements ValidationRule',
            'public $implicit = true;',
            'public function validate(string $attribute, mixed $value, Closure $fail): void',
        ], 'app/Rules/FooBar.php');
    }
}
