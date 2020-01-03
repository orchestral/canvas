<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

class JobTest extends TestCase
{
    protected $files = [
        'app/Jobs/FooCreated.php',
    ];

    /** @test */
    public function it_can_generate_job_file()
    {
        $this->artisan('make:job', ['name' => 'FooCreated'])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Jobs;',
            'use Illuminate\Bus\Queueable;',
            'use Illuminate\Contracts\Queue\ShouldQueue;',
            'use Illuminate\Foundation\Bus\Dispatchable;',
            'use Illuminate\Queue\InteractsWithQueue;',
            'use Illuminate\Queue\SerializesModels;',
            'class FooCreated implements ShouldQueue',
        ], 'app/Jobs/FooCreated.php');
    }

    /** @test */
    public function it_can_generate_synced_job_file()
    {
        $this->artisan('make:job', ['name' => 'FooCreated', '--sync' => true])
            ->assertExitCode(0);

        $this->assertFileContains([
            'namespace App\Jobs;',
            'use Illuminate\Bus\Queueable;',
            'use Illuminate\Foundation\Bus\Dispatchable;',
            'class FooCreated',
        ], 'app/Jobs/FooCreated.php');

        $this->assertFileNotContains([
            'use Illuminate\Contracts\Queue\ShouldQueue;',
            'use Illuminate\Queue\InteractsWithQueue;',
            'use Illuminate\Queue\SerializesModels;',
        ], 'app/Jobs/FooCreated.php');
    }
}
