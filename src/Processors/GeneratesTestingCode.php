<?php

namespace Orchestra\Canvas\Processors;

use Illuminate\Support\Str;
use Orchestra\Canvas\Core\GeneratesCode;
use Orchestra\Canvas\Core\Presets\Laravel;

class GeneratesTestingCode extends GeneratesCode
{
    /**
     * Build the class with the given name.
     */
    protected function buildClass(string $name): string
    {
        $testCase = $this->options['unit']
            ? $this->preset->config('testing.extends.unit', 'PHPUnit\Framework\TestCase')
            : $this->preset->config(
                'testing.extends.feature',
                $this->preset instanceof Laravel ? 'Tests\TestCase' : 'Orchestra\Testbench\TestCase'
            );

        return $this->replaceTestCase(parent::buildClass($name), $testCase);
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
     * Get the destination class path.
     */
    protected function getPath(string $name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return sprintf(
            '%s/tests/%s',
            $this->preset->basePath(),
            str_replace('\\', '/', $name).'.php'
        );
    }

    /**
     * Get the root namespace for the class.
     */
    protected function rootNamespace(): string
    {
        return $this->preset->config('testing.namespace', 'Tests');
    }
}
