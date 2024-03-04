<?php

namespace JayPatel\ServiceRepository;

use Illuminate\Support\ServiceProvider;
use JayPatel\ServiceRepository\Commands\GenerateServiceRepository;

class ServiceRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GenerateServiceRepository::class, function ($app) {
            return new GenerateServiceRepository();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Stubs' => base_path('app/stubs'),
        ], 'service-repository-stubs');
    }
}
