<?php

declare(strict_types=1);

namespace DragonCode\LaravelHttpLogger\Providers;

use DragonCode\LaravelHttpLogger\Http\Middleware\HttpLogMiddleware;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class RouteServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        foreach ($this->groups() as $group) {
            $this->registerMiddleware($group);
        }
    }

    protected function registerMiddleware(string $group): void
    {
        $this->kernel()->prependMiddlewareToGroup($group, HttpLogMiddleware::class);
    }

    protected function groups(): array
    {
        return array_keys($this->kernel()->getMiddlewareGroups());
    }

    protected function kernel(): Kernel
    {
        return $this->app->make(Kernel::class);
    }
}
