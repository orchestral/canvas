<?php

namespace Orchestra\Canvas\Commands;

use Orchestra\Canvas\Contracts\GeneratesCodeListener;
use Orchestra\Canvas\Presets\Preset;
use Orchestra\Canvas\Processors\GeneratesCode;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Generator extends Command implements GeneratesCodeListener
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type;

    /**
     * The type of file being generated.
     *
     * @var string
     */
    protected $fileType = 'class';

    /**
     * Generator processor.
     *
     * @var string
     */
    protected $processor = GeneratesCode::class;

    /**
     * Construct a new generator command.
     */
    public function __construct(Preset $preset)
    {
        $this->files = $preset->filesystem();

        parent::__construct($preset);
    }

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this->setName($this->name)
                ->setDescription($this->description)
                ->addArgument('name', InputArgument::REQUIRED, "The name of the {$this->fileType}");

        $this->specifyParameters();
    }

    /**
     * Execute the command.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     * @return int 0 if everything went fine, or an exit code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $this->getNameInput();
        $force = $this->hasOption('force') && $this->option('force') === true;
        $class = $this->processor;

        $processor = new $class($this->preset, $this);

        return $processor($listener, $force);
    }

    /**
     * Code already exists.
     */
    public function codeAlreadyExists(string $className): int
    {
        $this->error($this->type.' already exists!');

        return 1;
    }

    /**
     * Code successfully generated.
     */
    public function codeHasBeenGenerated(string $className): int
    {
        $this->info($this->type.' created successfully.');

        return 0;
    }

    /**
     * Get the default namespace for the class.
     */
    public function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace;
    }

    /**
     * Generator options.
     */
    public function generatorOptions(): array
    {
        return [];
    }

    /**
     * Get the desired class name from the input.
     */
    protected function getNameInput(): string
    {
        return \trim($this->argument('name'));
    }
}
