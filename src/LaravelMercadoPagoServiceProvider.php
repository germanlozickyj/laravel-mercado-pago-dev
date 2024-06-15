<?php

namespace Germanlozickyj\LaravelMercadoPago;

use Illuminate\Support\ServiceProvider;

class LaravelMercadoPagoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->bootMigrations();
    }

    private function bootMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/mercado-pago.php' => config_path('mercado-pago.php'),
            ], 'mercado-pago-config');
        }
    }
}
