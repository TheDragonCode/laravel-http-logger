<?php

declare(strict_types=1);

namespace Tests;

use DragonCode\LaravelHttpLogger\Models\HttpLog;

class HideTest extends TestCase
{
    public function testLogging(): void
    {
        $method = 'POST';
        $name   = 'api.pages.create';
        $path   = 'api/pages';

        $uri = $path . '?' . http_build_query([
            'foo'          => 'Foo',
            'token'        => 123,
            'access_token' => 456,
        ]);

        $this->assertDatabaseLogsCount(0);

        $response = $this->post($uri, [
            'bar' => 'Bar',

            'password'              => 'q123456',
            'password_confirmation' => 'q123456',
        ], [
            'Authorization' => 'Bearer QwErTy',
        ]);

        $response->assertNoContent();

        $this->assertDatabaseLogsCount(1);
        $this->assertDatabaseHasRecord($method, $name, $path);

        $log = HttpLog::where(compact('method', 'name'))->first();

        $this->assertSame($method, $log->method);
        $this->assertSame($name, $log->name);
        $this->assertSame($path, $log->path);

        $this->assertSame('http', $log->scheme);
        $this->assertSame('localhost', $log->host);
        $this->assertSame(80, $log->port);
        $this->assertSame('127.0.0.1', $log->ip);

        $this->assertSame([
            'foo'          => 'Foo',
            'token'        => '***',
            'access_token' => '***',
        ], $log->query);

        $this->assertSame([
            'bar' => 'Bar',

            'password'              => '*******',
            'password_confirmation' => '*******',
        ], $log->payload);

        $this->assertSame([
            'host'            => ['localhost'],
            'user-agent'      => ['Symfony'],
            'accept'          => ['text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'],
            'accept-language' => ['en-us,en;q=0.5'],
            'accept-charset'  => ['ISO-8859-1,utf-8;q=0.7,*;q=0.7'],
            'authorization'   => ['*************'],
            'content-type'    => ['application/x-www-form-urlencoded'],
        ], $log->headers);
    }
}
