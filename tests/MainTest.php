<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Support\Str;

class MainTest extends TestCase
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
            $this->assertDatabaseHasRecord(Str::upper($method), $name, $uri);
        }
    }

    public function testUnknownRoute()
    {
        $this->get('foo')->assertNotFound();
    }
}
