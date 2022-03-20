<?php

declare(strict_types=1);

namespace DragonCode\LaravelHttpLogger\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerConfig();
    }

    public function boot()
    {
        $this->publishConfig();
        $this->bootMigrations();
    }

    protected function bootMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    protected function publishConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/logging.php' => config_path('logging.php'),
        ], 'config');
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/logging.php', 'logging');
    }
}
