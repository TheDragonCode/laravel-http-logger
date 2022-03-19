<?php

declare(strict_types=1);

namespace DragonCode\LaravelHttpLogger;

use DragonCode\LaravelHttpLogger\Http\Middleware\HttpLogMiddleware;
use Illuminate\Contracts\Http\Kernel;
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
        $this->bootMiddleware();
    }

    protected function bootMiddleware(): void
    {
        $this->kernel()->prependMiddleware(HttpLogMiddleware::class);
    }

    protected function bootMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function publishConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../config/logging.php' => config_path('logging.php'),
        ], 'config');
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/logging.php', 'logging');
    }

    protected function kernel(): Kernel
    {
        return $this->app->make(Kernel::class);
    }
}
