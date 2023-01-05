<?php

namespace Orchestra\Canvas\Commands;

use Illuminate\Support\Str;
use Orchestra\Canvas\Processors\GeneratesCodeWithMarkdown;
use Symfony\Component\Console\Input\InputOption;

/**
 * @see https://github.com/laravel/framework/blob/9.x/src/Illuminate/Foundation/Console/MailMakeCommand.php
 */
class Mail extends Generator
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new email class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected string $type = 'Mail';

    /**
     * Generator processor.
     *
     * @var string
     */
    protected $processor = GeneratesCodeWithMarkdown::class;

    /**
     * Code successfully generated.
     */
    public function codeHasBeenGenerated(string $className): int
    {
        $exitCode = parent::codeHasBeenGenerated($className);

        if ($this->option('markdown') !== false) {
            $this->writeMarkdownTemplate();
        }

        return $exitCode;
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
        return $this->option('markdown')
            ? 'markdown-mail.stub'
            : 'mail.stub';
    }

    /**
     * Get the default namespace for the class.
     */
    public function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Mail';
    }

    /**
     * Generator options.
     *
     * @return array<string, mixed>
     */
    public function generatorOptions(): array
    {
        return [
            'markdown' => $this->option('markdown') ?? null,
            'view' => $this->componentView(),
        ];
    }

    /**
     * Write the Markdown template for the mailable.
     */
    protected function writeMarkdownTemplate(): void
    {
        $path = $this->preset->resourcePath().'/views/'.str_replace('.', '/', $this->componentView()).'.blade.php';

        if (! $this->files->isDirectory(\dirname($path))) {
            $this->files->makeDirectory(\dirname($path), 0755, true);
        }

        $this->files->put($path, (string) file_get_contents(__DIR__.'/../../storage/laravel/markdown.stub'));
    }

    /**
     * Get the view name.
     *
     * @return string
     */
    protected function componentView(): string
    {
        /** @var string|null $view */
        $view = $this->option('markdown');

        if (! $view) {
            /** @var string $name */
            $name = $this->argument('name');

            $view = 'mail.'.Str::kebab(class_basename($name));
        }

        return $view;
    }

    /**
     * Get the console command options.
     *
     * @return array<int, array>
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the mailable already exists'],
            ['markdown', 'm', InputOption::VALUE_OPTIONAL, 'Create a new Markdown template for the mailable', false],
        ];
    }
}
