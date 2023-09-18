<?php

namespace Illuminate\Tests\Integration\Generators;

class RuleMakeCommandTest extends TestCase
{
    protected $files = [
        'app/Rules/Foo.php',
    ];

    public function testItCanGenerateRuleFile()
    {
        $this->artisan('make:rule', ['name' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Rules;',
            'use Illuminate\Contracts\Validation\Rule;',
            'class Foo implements Rule',
        ], 'app/Rules/Foo.php');
    }

    public function testItCanGenerateInvokableRuleFile()
    {
        $this->artisan('make:rule', ['name' => 'Foo'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Rules;',
            'use Illuminate\Contracts\Validation\Rule;',
            'class Foo implements Rule',
        ], 'app/Rules/Foo.php');
    }

    public function testItCanGenerateImplicitRuleFile()
    {
        $this->artisan('make:rule', ['name' => 'Foo', '--implicit' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Rules;',
            'use Illuminate\Contracts\Validation\ImplicitRule;',
            'class Foo implements ImplicitRule',
            'public function passes($attribute, $value)',
        ], 'app/Rules/Foo.php');
    }
}
