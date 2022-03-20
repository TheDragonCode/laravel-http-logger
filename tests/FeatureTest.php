<?php

declare(strict_types=1);

namespace Tests;

use DragonCode\LaravelHttpLogger\Models\HttpLog;
use Illuminate\Support\Str;

class FeatureTest extends TestCase
{
    public function testLogging()
    {
        $count = 0;

        foreach ($this->routes as $route) {
            [$method, $name, $uri] = $route;

            $uri = Str::replace('{page}', Str::random(), $uri);

            $this->assertDatabaseLogsCount($count);

            /** @var \Illuminate\Testing\TestResponse $response */
            $response = $this->{$method}($uri);

            $response->assertNoContent();

            $this->assertDatabaseLogsCount(++$count);
            $this->assertDatabaseHasRecord($method, $name, $uri);
        }
    }

    public function testUnknownRoute()
    {
        $this->get('foo')->assertNotFound();
    }

    protected function assertDatabaseLogsCount(int $count): void
    {
        $this->assertSame($count, HttpLog::query()->count());
    }

    protected function assertDatabaseHasRecord(string $method, string $name, string $path, int $expected = 1): void
    {
        $method = Str::upper($method);

        $count = HttpLog::where(compact('method', 'name', 'path'))->count();

        $message = $method . ' ' . $path . ' ' . $name;

        $this->assertSame($expected, $count, $message);
    }
}
