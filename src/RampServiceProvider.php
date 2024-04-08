<?php
namespace R0aringthunder\RampApi;

use Illuminate\Support\ServiceProvider;

/**
 * Service provider for the RampAPI package.
 * 
 * This service provider is responsible for bootstrapping the RampAPI package, including publishing configuration
 * files and registering services into the Laravel application container.
 */
class RampServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     * 
     * Publishes the package configuration file to the application's config directory. This allows users of your package
     * to easily customize their own settings. The 'boot' method is automatically called by Laravel after all services
     * have been registered, meaning all other service providers have been registered and you have access to all other
     * services that have been registered by the framework.
     */
    public function boot() {
        $this->publishes([
            __DIR__.'/config/ramp.php' => config_path('ramp.php'),
        ], 'rampapi-config');
    }

    /**
     * Register services.
     * 
     * Merges the package's default configuration from a file into the application's shared configuration array, and
     * registers the AccountingConnectionsService into the service container as a singleton. The 'register' method is
     * automatically called by Laravel as part of the bootstrapping process and is a place to register bindings with the
     * service container or perform other initialization tasks.
     */
    public function register() {
        $this->mergeConfigFrom(
            __DIR__.'/config/ramp.php', 'ramp'
        );
        $this->app->singleton(AccountingConnectionsService::class, function ($app) {
            return new AccountingConnectionsService($app->make(Ramp::class));
        });
    }
}