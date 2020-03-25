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
            'job.queued.stub' => $stubsPath.'/job.queued.stub',
            'job.stub' => $stubsPath.'/job.stub',
            'model.pivot.stub' => $stubsPath.'/model.pivot.stub',
            'model.stub' => $stubsPath.'/model.stub',
            'request.stub' => $stubsPath.'/request.stub',
            'test.stub' => $stubsPath.'/test.stub',
            'test.unit.stub' => $stubsPath.'/test.unit.stub',
            'migration.create.stub' => $stubsPath.'/migration.create.stub',
            'migration.stub' => $stubsPath.'/migration.stub',
            'migration.update.stub' => $stubsPath.'/migration.update.stub',
            'factory.stub' => $stubsPath.'/factory.stub',
            'policy.plain.stub' => $stubsPath.'/policy.plain.stub',
            'policy.stub' => $stubsPath.'/policy.stub',
            'rule.stub' => $stubsPath.'/rule.stub',
            'console.stub' => $stubsPath.'/console.stub',
            'controller.api.stub' => $stubsPath.'/controller.api.stub',
            'controller.invokable.stub' => $stubsPath.'/controller.invokable.stub',
            'controller.model.api.stub' => $stubsPath.'/controller.model.api.stub',
            'controller.model.stub' => $stubsPath.'/controller.model.stub',
            'controller.nested.api.stub' => $stubsPath.'/controller.nested.api.stub',
            'controller.nested.stub' => $stubsPath.'/controller.nested.stub',
            'controller.plain.stub' => $stubsPath.'/controller.plain.stub',
            'controller.stub' => $stubsPath.'/controller.stub',
            'middleware.stub' => $stubsPath.'/middleware.stub',
        ];

        $force = $this->option('force');

        foreach ($files as $from => $to) {
            if (! \file_exists($to) || $force) {
                \file_put_contents($to, \file_get_contents($this->getStubFileFromPresetStorage($this->preset, $from)));
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
