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
            'class FooBar implements Rule',
        ], 'app/Rules/FooBar.php');
    }
}
