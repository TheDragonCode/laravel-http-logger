<?php

declare(strict_types=1);

namespace Tests;

use DragonCode\LaravelHttpLogger\Providers\RouteServiceProvider;
use DragonCode\LaravelHttpLogger\Providers\ServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Router;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Tests\Concerns\HasDatabase;

class TestCase extends BaseTestCase
{
    use HasDatabase;
    use RefreshDatabase;

    protected string $host = 'https://localhost';

    protected array $routes = [
        ['get', 'api.pages.index', 'api/pages'],
        ['post', 'api.pages.create', 'api/pages'],
        ['put', 'api.pages.update', 'api/pages/{page}'],
        ['patch', 'api.pages.edit', 'api/pages/{page}'],
        ['options', 'api.pages.options', 'api/pages/{page}'],
        ['delete', 'api.pages.destroy', 'api/pages/{page}'],
    ];

    protected function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
            RouteServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->setRoutes($app['router']);
    }

    protected function setRoutes(Router $route): void
    {
        foreach ($this->routes as $item) {
            [$method, $name, $uri] = $item;

            $route->{$method}($uri, fn () => response()->noContent())
                ->middleware('web')
                ->name($name);
        }
    }

    protected function getRoutePath(string $name): string
    {
        return $this->routes[$name];
    }
}
