<?php

namespace Orchestra\Canvas\Console;

use Illuminate\Support\Str;
use Orchestra\Canvas\GeneratorPreset;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:test', description: 'Create a new test class')]
class TestMakeCommand extends \Illuminate\Foundation\Console\TestMakeCommand
{
    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $preset = $this->generatorPreset();

        $stub = parent::replaceClass($stub, $name);

        $testCase = $this->option('unit')
            ? $preset->canvas()->config('testing.extends.unit', 'PHPUnit\Framework\TestCase')
            : $preset->canvas()->config(
                'testing.extends.feature',
                $preset->canvas()->is('laravel') ? 'Tests\TestCase' : 'Orchestra\Testbench\TestCase'
            );

        return $this->replaceTestCase($stub, $testCase);
    }

    /**
     * Replace the model for the given stub.
     */
    protected function replaceTestCase(string $stub, string $testCase): string
    {
        $namespaceTestCase = $testCase = str_replace('/', '\\', $testCase);

        if (Str::startsWith($testCase, '\\')) {
            $stub = str_replace('NamespacedDummyTestCase', trim($testCase, '\\'), $stub);
        } else {
            $stub = str_replace('NamespacedDummyTestCase', $namespaceTestCase, $stub);
        }

        $stub = str_replace(
            "use {$namespaceTestCase};\nuse {$namespaceTestCase};", "use {$namespaceTestCase};", $stub
        );

        $testCase = class_basename(trim($testCase, '\\'));

        return str_replace('DummyTestCase', $testCase, $stub);
    }

    /**
     * Resolve the default fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveDefaultStubPath($stub)
    {
        $preset = $this->generatorPreset();

        if ($preset instanceof GeneratorPreset) {
            return __DIR__.$stub;
        }

        return parent::resolveDefaultStubPath($stub);
    }
}
