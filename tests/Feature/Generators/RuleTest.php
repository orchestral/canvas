<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

class RuleTest extends TestCase
{
    protected $files = [
        'app/Rules/FooBar.php',
    ];

    /** @test */
    public function it_can_generate_rule_file()
    {
        $this->artisan('make:rule', ['name' => 'FooBar'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Rules;',
            'use Illuminate\Contracts\Validation\ValidationRule;',
            'class FooBar implements ValidationRule',
        ], 'app/Rules/FooBar.php');
    }

    /** @test */
    public function it_can_generate_invokable_rule_file()
    {
        $this->artisan('make:rule', ['name' => 'FooBar', '--invokable' => true])
            ->assertExitCode(0);

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
        $this->artisan('make:rule', ['name' => 'FooBar', '--invokable' => true, '--implicit' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Rules;',
            'use Illuminate\Contracts\Validation\InvokableRule;',
            'class FooBar implements InvokableRule',
            'public $implicit = true;',
            'public function __invoke($attribute, $value, $fail)',
        ], 'app/Rules/FooBar.php');
    }
}
