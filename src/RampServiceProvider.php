<?php
namespace R0aringthunder\RampApi;

use Illuminate\Support\ServiceProvider;

class RampServiceProvider extends ServiceProvider {
    public function boot() {
        $this->publishes([
            __DIR__.'/config/ramp.php' => config_path('ramp.php'),
        ], 'rampapi-config');
    }

    public function register() {
        $this->mergeConfigFrom(
            __DIR__.'/config/ramp.php', 'ramp'
        );
        $this->app->singleton(AccountingConnectionsService::class, function ($app) {
            return new AccountingConnectionsService($app->make(Ramp::class));
        });
    }
}