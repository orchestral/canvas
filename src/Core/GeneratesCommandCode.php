<?php

namespace Orchestra\Canvas\Core;

class GeneratesCommandCode extends GeneratesCode
{
    /**
     * Replace the class name for the given stub.
     *
     * @todo need to be updated
     */
    protected function replaceClass(string $stub, string $name): string
    {
        $stub = parent::replaceClass($stub, $name);

        return \str_replace('dummy:command', $this->options['command'], $stub);
    }
}
