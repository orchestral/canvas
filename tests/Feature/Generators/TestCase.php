<?php

namespace Orchestra\Canvas\Tests\Feature\Generators;

class TestCase extends \Orchestra\Canvas\Core\Testing\TestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Orchestra\Canvas\LaravelServiceProvider::class,
        ];
    }
}
