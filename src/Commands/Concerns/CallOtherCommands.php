<?php

namespace Orchestra\Canvas\Commands\Concerns;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

trait CallOtherCommands
{
    /**
     * Call another console command.
     *
     * @param  string  $command
     * @param  array  $arguments
     * @return int
     */
    public function call(string $command, array $arguments = []): int
    {
        return $this->runCommand($command, $arguments, $this->output);
    }
    /**
     * Call another console command silently.
     *
     * @param  string  $command
     * @param  array  $arguments
     * @return int
     */
    public function callSilent(string $command, array $arguments = []): int
    {
        return $this->runCommand($command, $arguments, new NullOutput);
    }
    /**
     * Run the given the console command.
     *
     * @param  string  $command
     * @param  array  $arguments
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
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
     * @return \Symfony\Component\Console\Command\Command
     */
    protected function resolveCommand($command): SymfonyCommand
    {
        return $this->getApplication()->find($command);
    }

    /**
     * Create an input instance from the given arguments.
     *
     * @param  array  $arguments
     * @return \Symfony\Component\Console\Input\ArrayInput
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
