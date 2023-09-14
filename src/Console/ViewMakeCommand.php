<?php

namespace Orchestra\Canvas\Console;

use Illuminate\Support\Str;
use Orchestra\Canvas\GeneratorPreset;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:view', description: 'Create a new view')]
class ViewMakeCommand extends \Illuminate\Foundation\Console\ViewMakeCommand
{
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

    /**
     * Create the matching test case if requested.
     *
     * @param  string  $path
     */
    protected function handleTestCreation($path): bool
    {
        if (! $this->option('test') && ! $this->option('pest')) {
            return false;
        }

        $preset = $this->generatorPreset();

        if (! $preset instanceof GeneratorPreset) {
            return parent::handleTestCreation($path);
        }

        $namespaceTestCase = $testCase = $preset->canvas()->config(
            'testing.extends.feature',
            $preset->canvas()->is('laravel') ? 'Tests\TestCase' : 'Orchestra\Testbench\TestCase'
        );

        $stub = $this->files->get($this->getTestStub());

        if (Str::startsWith($testCase, '\\')) {
            $stub = str_replace('NamespacedDummyTestCase', trim($testCase, '\\'), $stub);
        } else {
            $stub = str_replace('NamespacedDummyTestCase', $namespaceTestCase, $stub);
        }

        $contents = str_replace(
            ['{{ namespace }}', '{{ class }}', '{{ name }}', 'DummyTestCase'],
            [$this->testNamespace(), $this->testClassName(), $this->testViewName(), class_basename(trim($testCase, '\\'))],
            $stub,
        );

        $this->files->ensureDirectoryExists(\dirname($this->getTestPath()), 0755, true);

        return $this->files->put($this->getTestPath(), $contents) !== false;
    }
}
