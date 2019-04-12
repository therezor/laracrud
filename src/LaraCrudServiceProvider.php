<?php

namespace TheRezor\LaraCrud;

use Illuminate\Support\ServiceProvider;
use TheRezor\LaraCrud\Console\CrudControllerMakeCommand;
use TheRezor\LaraCrud\Console\CrudFormMakeCommand;
use TheRezor\LaraCrud\Console\CrudMakeCommand;
use TheRezor\LaraCrud\Console\CrudRepositoryMakeCommand;

class LaraCrudServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap the service.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laracrud');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'laracrud');

        $this->publishes([
            __DIR__ . '/../resources/views'     => base_path('resources/views/vendor/laracrud'),
        ]);

        $this->publishes([
            __DIR__ . '/../resources/js'  => public_path('vendor/laracrud'),
            __DIR__ . '/../resources/css' => public_path('vendor/laracrud'),
        ], 'public');

        $this->commands([
            CrudControllerMakeCommand::class,
            CrudFormMakeCommand::class,
            CrudRepositoryMakeCommand::class,
            CrudMakeCommand::class
        ]);
    }

    /**
     * Get the services provided by this provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return ['laracrud'];
    }
}
