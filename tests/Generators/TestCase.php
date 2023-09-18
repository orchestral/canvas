<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

use Orchestra\Testbench\Concerns\InteractsWithPublishedFiles;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use InteractsWithPublishedFiles;

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Orchestra\Canvas\Core\LaravelServiceProvider::class,
        ];
    }
}
