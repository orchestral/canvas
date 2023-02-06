<?php

namespace Orchestra\Canvas\Commands;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Orchestra\Canvas\Processors\GeneratesCodeWithComponent;
use Symfony\Component\Console\Input\InputOption;

/**
 * @see https://github.com/laravel/framework/blob/10.x/src/Illuminate/Foundation/Console/ComponentMakeCommand.php
 */
#[\Symfony\Component\Console\Attribute\AsCommand(name: 'make:component')]
class Component extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:component';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new view component class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected string $type = 'Component';

    /**
     * Generator processor.
     *
     * @var string
     */
    protected $processor = GeneratesCodeWithComponent::class;

    /**
     * Code successfully generated.
     */
    public function codeHasBeenGenerated(string $className): int
    {
        $exitCode = parent::codeHasBeenGenerated($className);

        if (! $this->option('inline')) {
            $this->writeView();
        }

        return $exitCode;
    }

    /**
     * Write the view for the component.
     *
     * @return void
     */
    protected function writeView()
    {
        /** @var string $name */
        $name = $this->argument('name');

        $view = Collection::make(explode('/', $name))
            ->map(static function ($part) {
                return Str::kebab($part);
            })->implode('.');

        $path = $this->preset->resourcePath().'/views/'.str_replace('.', '/', 'components.'.$view);

        if (! $this->files->isDirectory(\dirname($path))) {
            $this->files->makeDirectory(\dirname($path), 0777, true, true);
        }

        $this->files->put(
            $path.'.blade.php',
            '<div>
    <!-- Insert your component content -->
</div>'
        );
    }

    /**
     * Get the stub file for the generator.
     */
    public function getStubFile(): string
    {
        return $this->getStubFileFromPresetStorage($this->preset, $this->getStubFileName());
    }

    /**
     * Get the stub file name for the generator.
     */
    public function getStubFileName(): string
    {
        return 'view-component.stub';
    }

    /**
     * Get the default namespace for the class.
     */
    public function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\View\Components';
    }

    /**
     * Get the view name relative to the components directory.
     */
    protected function componentView(): string
    {
        /** @var string $name */
        $name = $this->argument('name');

        $name = str_replace('\\', '/', $name);

        return collect(explode('/', $name))
            ->map(function ($part) {
                return Str::kebab($part);
            })
            ->implode('.');
    }

    /**
     * Generator options.
     *
     * @return array<string, mixed>
     */
    public function generatorOptions(): array
    {
        return [
            'name' => $this->generatorName(),
            'inline' => $this->option('inline'),
            'force' => $this->option('force'),
            'view' => $this->componentView(),
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array<int, array>
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the component already exists'],
            ['inline', null, InputOption::VALUE_NONE, 'Create a component that renders an inline view'],
        ];
    }
}
