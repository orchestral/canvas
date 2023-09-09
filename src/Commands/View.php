<?php

namespace Orchestra\Canvas\Commands;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Orchestra\Canvas\Processors\GeneratesViewCode;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * @see https://github.com/laravel/framework/blob/10.x/src/Illuminate/Foundation/Console/ViewMakeCommand.php
 */
#[AsCommand(name: 'make:view', description: 'Create a new view')]
class View extends Generator
{
    use CreatesMatchingTest;

    /**
     * The type of file being generated.
     *
     * @var string
     */
    protected string $type = 'View';

    /**
     * Generator processor.
     *
     * @var class-string<\Orchestra\Canvas\Core\GeneratesCode>
     */
    protected string $processor = GeneratesViewCode::class;

    /**
     * Handle generating code.
     */
    public function generatingCode(string $stub, string $name): string
    {
        $stub = parent::generatingCode($stub, $name);

        return str_replace(
            '{{ quote }}',
            Inspiring::quotes()->random(),
            $stub,
        );
    }

    /**
     * Get the stub file name for the generator.
     */
    public function getStubFileName(): string
    {
        return 'view.stub';
    }

    /**
     * Get the destination test case path.
     *
     * @return string
     */
    protected function getTestPath()
    {
        return base_path(
            Str::of($this->testClassFullyQualifiedName())
                ->replace('\\', '/')
                ->replaceFirst('Tests/Feature', 'tests/Feature')
                ->append('Test.php')
                ->value()
        );
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

        $contents = preg_replace(
            ['/\{{ namespace \}}/', '/\{{ class \}}/', '/\{{ name \}}/'],
            [$this->testNamespace(), $this->testClassName(), $this->testViewName()],
            File::get($this->getTestStub()),
        );

        File::ensureDirectoryExists(\dirname($this->getTestPath()), 0755, true);

        return File::put($this->getTestPath(), $contents);
    }

    /**
     * Get the namespace for the test.
     *
     * @return string
     */
    protected function testNamespace()
    {
        return Str::of($this->testClassFullyQualifiedName())
            ->beforeLast('\\')
            ->value();
    }

    /**
     * Get the class name for the test.
     *
     * @return string
     */
    protected function testClassName()
    {
        return Str::of($this->testClassFullyQualifiedName())
            ->afterLast('\\')
            ->append('Test')
            ->value();
    }

    /**
     * Get the class fully qualified name for the test.
     *
     * @return string
     */
    protected function testClassFullyQualifiedName()
    {
        $name = Str::of(Str::lower($this->generatorName()))->replace('.'.$this->option('extension'), '');

        $namespacedName = Str::of(
            Str::of($name)
                ->replace('/', ' ')
                ->explode(' ')
                ->map(fn ($part) => Str::of($part)->ucfirst())
                ->implode('\\')
        )
            ->replace(['-', '_'], ' ')
            ->explode(' ')
            ->map(fn ($part) => Str::of($part)->ucfirst())
            ->implode('');

        return 'Tests\\Feature\\View\\'.$namespacedName;
    }

    /**
     * Get the test stub file for the generator.
     *
     * @return string
     */
    protected function getTestStub()
    {
        $filename = 'view.'.($this->option('pest') ? 'pest' : 'test').'.stub';

        return $this->getStubFileFromPresetStorage($this->preset, $filename);
    }

    /**
     * Get the view name for the test.
     *
     * @return string
     */
    protected function testViewName()
    {
        return Str::of($this->generatorName())
            ->replace('/', '.')
            ->lower()
            ->value();
    }
    /**
     * Generator options.
     *
     * @return array<string, mixed>
     */
    public function generatorOptions(): array
    {
        return array_merge(parent::generatorOptions(), [
            'extension' => $this->option('extension'),
            'force' => $this->option('force'),
        ]);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['extension', null, InputOption::VALUE_OPTIONAL, 'The extension of the generated view', 'blade.php'],
            ['force', 'f', InputOption::VALUE_NONE, 'Create the view even if the view already exists'],
        ];
    }
}
