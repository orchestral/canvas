<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

class StubPublishTest extends TestCase
{
    protected $files = [
        'stubs/cast.stub',
        'stubs/console.stub',
        'stubs/controller.api.stub',
        'stubs/controller.invokable.stub',
        'stubs/controller.model.api.stub',
        'stubs/controller.model.stub',
        'stubs/controller.nested.api.stub',
        'stubs/controller.nested.stub',
        'stubs/controller.plain.stub',
        'stubs/controller.stub',
        'stubs/event.stub',
        'stubs/factory.stub',
        'stubs/job.queued.stub',
        'stubs/job.stub',
        'stubs/markdown-notification.stub',
        'stubs/middleware.stub',
        'stubs/migration.create.stub',
        'stubs/migration.stub',
        'stubs/migration.update.stub',
        'stubs/model.stub',
        'stubs/model.pivot.stub',
        'stubs/notification.stub',
        'stubs/observer.plain.stub',
        'stubs/observer.stub',
        'stubs/policy.stub',
        'stubs/policy.plain.stub',
        'stubs/request.stub',
        'stubs/resource-collection.stub',
        'stubs/resource.stub',
        'stubs/rule.stub',
        'stubs/seeder.stub',
        'stubs/test.stub',
        'stubs/test.unit.stub',
        'stubs/view-component.stub',
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
