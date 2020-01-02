<?php

namespace Orchestra\Canvas\Processors;

use Illuminate\Support\Str;
use Orchestra\Canvas\Contracts\GeneratesCodeListener;
use Orchestra\Canvas\Presets\Preset;

class GeneratesCode
{
    protected $preset;

    protected $files;

    protected $listener;

    protected $options = [];

    public function __construct(Preset $preset, GeneratesCodeListener $listener)
    {
        $this->preset = $preset;
        $this->files = $preset->getFilesystem();
        $this->listener = $listener;
        $this->options = $listener->generatorOptions();
    }

    public function create(string $name, bool $force = false)
    {
        $className = $this->qualifyClass($name);

        $path = $this->getPath($className);

        // First we will check to see if the class already exists. If it does, we don't want
        // to create the class and overwrite the user's code. So, we will bail out so the
        // code is untouched. Otherwise, we will continue generating this class' files.
        if (! force && $this->alreadyExists($name)) {
            return $this->listener->codeAlreadyExists($className);
        }

        // Next, we will generate the path to the location where this class' file should get
        // written. Then, we will build the class and make the proper replacements on the
        // stub files so that it gets the correctly formatted namespace and class name.
        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($className)));

        return $this->listener->codeHasBeenGenerated($className);
    }

    /**
     * Parse the class name and format according to the root namespace.
     */
    protected function qualifyClass(string $name): string
    {
        $name = \ltrim($name, '\\/');

        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        $name = \str_replace('/', '\\', $name);

        return $this->qualifyClass(
            $this->getDefaultNamespace(\trim($rootNamespace, '\\')).'\\'.$name
        );
    }

    /**
     * Get the default namespace for the class.
     */
    protected function getDefaultNamespace(string $rootNamespace): string
    {
        return $this->listener->getDefaultNamespace($rootNamespace);
    }

    /**
     * Determine if the class already exists.
     */
    protected function alreadyExists(string $rawName): bool
    {
        return $this->files->exists($this->getPath($this->qualifyClass($rawName)));
    }

    /**
     * Get the destination class path.
     */
    protected function getPath(string $name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->preset->sourcePath().'/'.\str_replace('\\', '/', $name).'.php';
    }

    /**
     * Build the directory for the class if necessary.
     */
    protected function makeDirectory(string $path): string
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    /**
     * Build the class with the given name.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass(string $name): string
    {
        $stub = $this->files->get($this->listener->getStubFile());

        return $this->replaceClass(
            $this->replaceNamespace($stub, $name), $name
        );
    }

    /**
     * Replace the namespace for the given stub.
     */
    protected function replaceNamespace(string $stub, string $name): string
    {
        return \str_replace(
            ['DummyNamespace', 'DummyRootNamespace', 'NamespacedDummyUserModel'],
            [$this->getNamespace($name), $this->rootNamespace(), $this->userProviderModel()],
            $stub
        );
    }

    /**
     * Get the full namespace for a given class, without the class name.
     */
    protected function getNamespace(string $name): string
    {
        return \trim(\implode('\\', \array_slice(\explode('\\', $name), 0, -1)), '\\');
    }

    /**
     * Replace the class name for the given stub.
     */
    protected function replaceClass(string $stub, string $name): string
    {
        $class = \str_replace($this->getNamespace($name).'\\', '', $name);

        return \str_replace(
            ['DummyClass', 'DummyUser'],
            [$class, \class_basename($this->userProviderModel())],
            $stub
        );
    }

    /**
     * Alphabetically sorts the imports for the given stub.
     */
    protected function sortImports(string $stub): string
    {
        if (\preg_match('/(?P<imports>(?:use [^;]+;$\n?)+)/m', $stub, $match)) {
            $imports = \explode("\n", \trim($match['imports']));

            \sort($imports);

            return \str_replace(\trim($match['imports']), \implode("\n", $imports), $stub);
        }

        return $stub;
    }

    /**
     * Get the root namespace for the class.
     */
    protected function rootNamespace(): string
    {
        return $this->preset->rootNamespace();
    }

    /**
     * Get the model for the default guard's user provider.
     */
    protected function userProviderModel(): ?string
    {
        return $this->preset->config('user-auth-provider');
    }
}
