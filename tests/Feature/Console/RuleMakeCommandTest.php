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
            'use Illuminate\Contracts\Validation\Rule;',
            'class FooBar implements Rule',
        ], 'app/Rules/FooBar.php');
    }

    /** @test */
    public function it_can_generate_invokable_rule_file()
    {
        $this->artisan('make:rule', ['name' => 'FooBar', '--invokable' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Rules;',
            'use Illuminate\Contracts\Validation\InvokableRule;',
            'class FooBar implements InvokableRule',
            'public function __invoke($attribute, $value, $fail)',
        ], 'app/Rules/FooBar.php');
    }

    /** @test */
    public function it_can_generate_invokable_implicit_rule_file()
    {
        $this->artisan('make:rule', ['name' => 'FooBar', '--invokable' => true, '--implicit' => true, '--preset' => 'canvas'])
            ->assertSuccessful();

        $this->assertFileContains([
            'namespace App\Rules;',
            'use Illuminate\Contracts\Validation\InvokableRule;',
            'class FooBar implements InvokableRule',
            'public $implicit = true;',
            'public function __invoke($attribute, $value, $fail)',
        ], 'app/Rules/FooBar.php');
    }
}
