<?php

namespace JayPatel\ServiceRepositoryPackage;

use Illuminate\Support\ServiceProvider;
use JayPatel\ServiceRepositoryPackage\Commands\GenerateServiceRepositoryCommand;

class ServiceRepositoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            GenerateServiceRepositoryCommand::class,
        ]);

    }

    public function register()
    {
    }
}
