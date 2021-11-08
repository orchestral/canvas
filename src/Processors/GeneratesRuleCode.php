<?php

namespace Orchestra\Canvas\Processors;

use Orchestra\Canvas\Core\GeneratesCode;

/**
 * @property \Orchestra\Canvas\Commands\Rule $listener
 *
 * @see https://github.com/laravel/framework/blob/8.x/src/Illuminate/Foundation/Console/RuleMakeCommand.php
 */
class GeneratesRuleCode extends GeneratesCode
{
    /**
     * Build the class with the given name.
     */
    protected function buildClass(string $name): string
    {
        return str_replace(
            '{{ ruleType }}',
            $this->options['implicit'] ? 'ImplicitRule' : 'Rule',
            parent::buildClass($name)
        );
    }
}
