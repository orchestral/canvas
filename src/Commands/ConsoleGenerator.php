<?php

namespace Orchestra\Canvas\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:generator', description: 'Create a new generator command')]
class ConsoleGenerator extends \Orchestra\Canvas\Core\Commands\Generators\ConsoleGenerator
{
    //
}
