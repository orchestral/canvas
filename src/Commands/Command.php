<?php

namespace Orchestra\Canvas\Commands;

use Illuminate\Console\OutputStyle;
use Orchestra\Canvas\Presets\Preset;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Command extends \Symfony\Component\Console\Command\Command
{
    use Concerns\Interaction;

    /**
     * Canvas preset.
     *
     * @var \Orchestra\Canvas\Presets\Preset
     */
    protected $preset;

    /**
     * Construct a new generator command.
     */
    public function __construct(Preset $preset)
    {
        $this->preset = $preset;

        parent::__construct();
    }

    /**
     * Run the console command.
     *
     * @return int
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->output = new OutputStyle($input, $output);

        return parent::run(
            $this->input = $input, $this->output
        );
    }

    /**
     * Specify the arguments and options on the command.
     *
     * @return void
     */
    protected function specifyParameters()
    {
        // We will loop through all of the arguments and options for the command and
        // set them all on the base command instance. This specifies what can get
        // passed into these commands as "parameters" to control the execution.
        foreach ($this->getArguments() as $arguments) {
            if ($arguments instanceof InputArgument) {
                $this->getDefinition()->addArgument($arguments);
            } else {
                \call_user_func_array([$this, 'addArgument'], $arguments);
            }
        }

        foreach ($this->getOptions() as $options) {
            if ($options instanceof InputOption) {
                $this->getDefinition()->addOption($options);
            } else {
                \call_user_func_array([$this, 'addOption'], $options);
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
