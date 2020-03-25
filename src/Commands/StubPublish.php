<?php

namespace Orchestra\Canvas\Commands;

use Orchestra\Canvas\Concerns\ResolvesPresetStubs;
use Orchestra\Canvas\Core\Commands\Command;
use Orchestra\Canvas\Core\Presets\Package;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class StubPublish extends Command
{
    use ResolvesPresetStubs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'stub:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all stubs that are available for customization';

    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->ignoreValidationErrors();

        $this->setName($this->name)
            ->setDescription($this->description);
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
        $files = $this->preset->filesystem();
        $stubsPath = \sprintf('%s/stubs', $this->preset->basePath());

        if (! $files->isDirectory($stubsPath)) {
            $files->makeDirectory($stubsPath);
        }

        $files = [
            \realpath(__DIR__.'/../../storage/laravel/job.queued.stub') => $stubsPath.'/job.queued.stub',
            \realpath(__DIR__.'/../../storage/laravel/job.stub') => $stubsPath.'/job.stub',
            \realpath(__DIR__.'/../../storage/laravel/database/eloquent/model.pivot.stub') => $stubsPath.'/model.pivot.stub',
            \realpath(__DIR__.'/../../storage/laravel/database/eloquent/model.stub') => $stubsPath.'/model.stub',
            \realpath(__DIR__.'/../../storage/laravel/request.stub') => $stubsPath.'/request.stub',
            \realpath($this->getStubFileFromPresetStorage($this->preset, 'test.stub')) => $stubsPath.'/test.stub',
            \realpath$this->getStubFileFromPresetStorage($this->preset, 'test.unit.stub')) => $stubsPath.'/test.unit.stub',
            \realpath(__DIR__.'/../../storage/laravel/database/migrations/migration.create.stub') => $stubsPath.'/migration.create.stub',
            \realpath(__DIR__.'/../../storage/laravel/database/migrations/migration.stub') => $stubsPath.'/migration.stub',
            \realpath(__DIR__.'/../../storage/laravel/database/migrations/migration.update.stub') => $stubsPath.'/migration.update.stub',
            realpath(__DIR__.'/../../storage/laravel/policy.plain.stub') => $stubsPath.'/policy.plain.stub',
            realpath(__DIR__.'/../../storage/laravel/policy.stub') => $stubsPath.'/policy.stub',
            \realpath(__DIR__.'/../../storage/laravel/controller.api.stub') => $stubsPath.'/controller.api.stub',
            \realpath(__DIR__.'/../../storage/laravel/controller.invokable.stub') => $stubsPath.'/controller.invokable.stub',
            \realpath(__DIR__.'/../../storage/laravel/controller.model.api.stub') => $stubsPath.'/controller.model.api.stub',
            \realpath(__DIR__.'/../../storage/laravel/controller.model.stub') => $stubsPath.'/controller.model.stub',
            \realpath(__DIR__.'/../../storage/laravel/controller.nested.api.stub') => $stubsPath.'/controller.nested.api.stub',
            \realpath(__DIR__.'/../../storage/laravel/controller.nested.stub') => $stubsPath.'/controller.nested.stub',
            \realpath(__DIR__.'/../../storage/laravel/controller.plain.stub') => $stubsPath.'/controller.plain.stub',
            \realpath(__DIR__.'/../../storage/laravel/controller.stub') => $stubsPath.'/controller.stub',
        ];

        $force = $this->option('force');

        foreach ($files as $from => $to) {
            if (! \file_exists($to) || $force) {
                \file_put_contents($to, \file_get_contents($from));
            }
        }

        $this->info('Stubs published successfully.');

        return 0;
    }

    /**
     * Get feature test stub file.
     */
    protected function getFeatureTestStubFile(): string
    {
        if ($this->preset instanceof Package) {
            return \realpath(__DIR__.'/../../storage/testing/test.package.stub');
        }

        return \realpath(__DIR__.'/../../storage/testing/test.stub');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Overwrite any existing files if already exists'],
        ];
    }
}
