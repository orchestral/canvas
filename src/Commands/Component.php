<?php

namespace Orchestra\Canvas\Commands;

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Str;
use Orchestra\Canvas\Processors\GeneratesCodeWithComponent;
use Symfony\Component\Console\Input\InputOption;

class Component extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'make:component';

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
    protected $type = 'Component';

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
        $view = 'components.'.Str::kebab(\class_basename($this->argument('name')));

        $path = $this->preset->resourcePath().'/views/'.\str_replace('.', '/', $view);

        if (! $this->files->isDirectory(\dirname($path))) {
            $this->files->makeDirectory(\dirname($path), 0777, true, true);
        }

        $this->files->put(
            $path.'.blade.php',
            '<div>
    <!-- '.Inspiring::quote().' -->
</div>'
        );
    }

    /**
     * Get the stub file for the generator.
     */
    public function getStubFile(): string
    {
        return '../../storage/laravel/view-component.stub';
    }

    /**
     * Get the default namespace for the class.
     */
    public function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\ViewComponents';
    }

    /**
     * Generator options.
     */
    public function generatorOptions(): array
    {
        return [
            'name' => $this->generatorName(),
            'inline' => $this->option('inline'),
            'force' => $this->option('force'),
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the component already exists'],
            ['inline', null, InputOption::VALUE_NONE, 'Create a component that renders an inline view'],
        ];
    }
}
