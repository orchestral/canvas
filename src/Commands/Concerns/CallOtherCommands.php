<?php

namespace Orchestra\Canvas\Commands\Concerns;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

trait CallOtherCommands
{
    /**
     * Call another console command.
     */
    public function call(string $command, array $arguments = []): int
    {
        return $this->runCommand($command, $arguments, $this->output);
    }

    /**
     * Call another console command silently.
     */
    public function callSilent(string $command, array $arguments = []): int
    {
        return $this->runCommand($command, $arguments, new NullOutput());
    }

    /**
     * Run the given the console command.
     */
    protected function runCommand(string $command, array $arguments, OutputInterface $output): int
    {
        $arguments['command'] = $command;

        return $this->resolveCommand($command)->run(
            $this->createInputFromArguments($arguments), $output
        );
    }

    /**
     * Resolve the console command instance for the given command.
     *
     * @param  string  $command
     */
    protected function resolveCommand($command): SymfonyCommand
    {
        return $this->getApplication()->find($command);
    }

    /**
     * Create an input instance from the given arguments.
     */
    protected function createInputFromArguments(array $arguments): ArrayInput
    {
        return \tap(new ArrayInput(\array_merge($this->context(), $arguments)), static function ($input) {
            if ($input->hasParameterOption(['--no-interaction'], true)) {
                $input->setInteractive(false);
            }
        });
    }
}
