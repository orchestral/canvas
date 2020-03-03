<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

class StubPublishTest extends TestCase
{
    protected $files = [
        'stubs/controller.api.stub',
        'stubs/controller.invokable.stub',
        'stubs/controller.model.api.stub',
        'stubs/controller.model.stub',
        'stubs/controller.nested.api.stub',
        'stubs/controller.nested.stub',
        'stubs/controller.plain.stub',
        'stubs/controller.stub',
        'stubs/job.queued.stub',
        'stubs/job.stub',
        'stubs/migration.create.stub',
        'stubs/migration.stub',
        'stubs/migration.update.stub',
        'stubs/model.stub',
        'stubs/test.stub',
        'stubs/test.unit.stub',
    ];

    /** @test */
    public function it_can_publish_stub_files()
    {
        $this->artisan('stub:publish')->assertExitCode(0);

        foreach ($this->files as $file) {
            $this->assertFilenameExists($file);
        }
    }
}
