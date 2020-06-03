<?php

namespace Twgroupcl\BaseCrud;

use Illuminate\Support\ServiceProvider;
use Twgroupcl\BaseCrud\app\Console\Commands\InstallBaseCrud;

class BaseCrudServiceProvider extends ServiceProvider
{
    protected $commands = [
        InstallBaseCrud::class,
    ];

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'basecrud');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'basecrud');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('basecrud.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/basecrud'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/basecrud'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/basecrud'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'basecrud');

        $this->commands($this->commands);

        // Register the main class to use with the facade
        $this->app->singleton('basecrud', function () {
            return new BaseCrud;
        });
    }
}
