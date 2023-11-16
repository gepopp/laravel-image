<?php

namespace Gepopp\Image;

use Gepopp\Image\Observers\ImageObserver;
use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'gepopp');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'gepopp');
        $this->loadMigrationsFrom( __DIR__ . '/../database/migrations', 'gepopp' );
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ( $this->app->runningInConsole() ) {
            $this->bootForConsole();
        }


        \Gepopp\Image\Model\Image::observe( ImageObserver::class );
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom( __DIR__ . '/../config/image.php', 'image' );

        // Register the service the package provides.
        $this->app->singleton( 'image', function ( $app ) {
            return new Image;
        } );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ 'image' ];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        //publish the nova resource
        $this->publishes( [
            __DIR__ . '/../Nova/Image.php' => app_path( 'Nova/Image.php' ),
        ], 'image.nova.resource' );


        // Publishing the configuration file.
        $this->publishes( [
            __DIR__ . '/../config/image.php' => config_path( 'image.php' ),
        ], 'image.config' );

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/gepopp'),
        ], 'image.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/gepopp'),
        ], 'image.assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/gepopp'),
        ], 'image.lang');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
