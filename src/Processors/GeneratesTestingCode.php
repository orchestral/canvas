<?php

namespace Orchestra\Canvas\Processors;

use Illuminate\Support\Str;
use Orchestra\Canvas\Core\GeneratesCode;

class GeneratesTestingCode extends GeneratesCode
{
    /**
     * Get the destination class path.
     */
    protected function getPath(string $name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return \sprintf(
            '%s/tests/%s',
            $this->preset->basePath(),
            \str_replace('\\', '/', $name).'.php'
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
