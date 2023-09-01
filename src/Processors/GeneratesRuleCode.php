<?php

namespace Orchestra\Canvas\Processors;

use Orchestra\Canvas\Core\GeneratesCode;

/**
 * @property \Orchestra\Canvas\Commands\Rule $listener
 *
 * @see https://github.com/laravel/framework/blob/9.x/src/Illuminate/Foundation/Console/RuleMakeCommand.php
 */
class GeneratesRuleCode extends GeneratesCode
{
    /**
     * Replace the namespace for the given stub.
     */
    protected function replaceNamespace(string $stub, string $name): string
    {
        $stub = parent::replaceNamespace($stub, $name);

        return str_replace(
            '{{ ruleType }}', $this->options['implicit'] ? 'ImplicitRule' : 'Rule', $stub
        );
    }
}
