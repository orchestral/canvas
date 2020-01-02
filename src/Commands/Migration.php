<?php

namespace Laravie\Canvas\Commands;

use Illuminate\Database\Console\Migrations\TableGuesser;
use Illuminate\Support\Composer;
use Illuminate\Support\Str;
use Laravie\Canvas\Database\MigrationCreator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Migration extends Command
{
    /**
     * The migration creator instance.
     *
     * @var \Laravie\Canvas\Database\MigrationCreator
     */
    protected $creator;

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this->setName('migration')
                ->setDescription('Create a new migration file.')
                ->addArgument('name', InputArgument::REQUIRED, 'The name of the migration')
                ->addOption('create', null, InputOption::VALUE_OPTIONAL, 'The table be created')
                ->addOption('table', null, InputOption::VALUE_OPTIONAL, 'The table to migrate')
                ->addOption('path', null, InputOption::VALUE_OPTIONAL, 'The location where the migration file should be created')
                ->addOption('realpath', null, InputOption::VALUE_NONE, 'Indicate any provided migration file paths are pre-resolved absolute paths')
                ->addOption('fullpath', null, InputOption::VALUE_NONE, 'Output the full path of the migration');

        $this->creator = new MigrationCreator($this->preset);

        $this->composer = new Composer($this->preset->filesystem(), $this->preset->basePath());
    }

    /**
     * Execute the command.
     *
     * @return int 0 if everything went fine, or an exit code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // It's possible for the developer to specify the tables to modify in this
        // schema operation. The developer may also specify if this table needs
        // to be freshly created so we can create the appropriate migrations.
        $name = Str::snake(\trim($input->getArgument('name')));

        $table = $input->getOption('table');

        $create = $input->getOption('create') ?: false;

        // If no table was given as an option but a create option is given then we
        // will use the "create" option as the table name. This allows the devs
        // to pass a table name into this option as a short-cut for creating.
        if (! $table && \is_string($create)) {
            $table = $create;
            $create = true;
        }

        // Next, we will attempt to guess the table name if this the migration has
        // "create" in the name. This will allow us to provide a convenient way
        // of creating migrations that create new tables for the application.
        if (! $table) {
            [$table, $create] = TableGuesser::guess($name);
        }

        // Now we are ready to write the migration out to disk. Once we've written
        // the migration out, we will dump-autoload for the entire framework to
        // make sure that the migrations are registered by the class loaders.
        $file = $this->writeMigration($input, $name, $table, $create);

        $this->composer->dumpAutoloads();

        $output->writeln("<info>Created Migration:</info> {$file}");

        return 0;
    }

    /**
     * Write the migration file to disk.
     */
    protected function writeMigration(InputInterface $input, string $name, string $table, bool $create): string
    {
        $file = $this->creator->create(
            $name, $this->getMigrationPath($input), $table, $create
        );

        if (! $this->usingFullPath($input)) {
            $file = \pathinfo($file, PATHINFO_FILENAME);
        }

        return $file;
    }

    /**
     * Get migration path (either specified by '--path' option or default location).
     */
    protected function getMigrationPath(InputInterface $input): string
    {
        if (! \is_null($targetPath = $input->getOption('path'))) {
            return ! $this->usingRealPath($input)
                            ? $this->preset->basePath().'/'.$targetPath
                            : $targetPath;
        }

        return $this->preset->migrationPath();
    }

    /**
     * Determine if the given path(s) are pre-resolved "real" paths.
     */
    protected function usingRealPath(InputInterface $input): bool
    {
        return $input->hasOption('realpath') && $input->getOption('realpath');
    }

    /**
     * Determine if the given path(s) are pre-resolved "full" paths.
     */
    protected function usingFullPath(InputInterface $input): bool
    {
        return $input->hasOption('fullpath') && $input->getOption('fullpath');
    }
}
