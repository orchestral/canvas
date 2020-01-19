<?php

namespace Orchestra\Canvas\Core;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

abstract class CommandServiceProvider extends ServiceProvider
{
    /**
     * Setup preset for laravel.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return \Orchestra\Canvas\Core\Presets\Laravel
     */
    protected function presetForLaravel(Application $app): Presets\Laravel
    {
        return new Presets\Laravel([
            'preset' => 'laravel',
            'namespace' => \trim($this->app->getNamespace(), '\\'),
            'user-auth-provider' => $this->userProviderModel(),
        ], $app->basePath(), $app->make('files'));
    }

    /**
     * Get the model for the default guard's user provider.
     */
    protected function userProviderModel(): ?string
    {
        $guard = \config('auth.defaults.guard');

        $provider = \config("auth.guards.{$guard}.provider");

        return \config("auth.providers.{$provider}.model");
    }
}
