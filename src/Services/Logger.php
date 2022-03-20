<?php

declare(strict_types=1);

namespace DragonCode\LaravelHttpLogger\Services;

use DragonCode\LaravelHttpLogger\Models\HttpLog;
use DragonCode\Support\Facades\Helpers\Arr;
use Illuminate\Http\Request;

class Logger
{
    public static function save(Request $request): void
    {
        self::store(
            $request->route()?->getName(),
            $request->getRealMethod(),
            $request->getScheme(),
            $request->getHost(),
            $request->getPort(),
            $request->path(),
            $request->query(),
            Arr::except($request->all(), array_keys($request->query())),
            $request->headers->all(),
            $request?->getClientIp() ?: $request?->ip()
        );
    }

    protected static function store(
        ?string           $name,
        string            $method,
        string            $scheme,
        string            $host,
        int|string|null   $port,
        string            $path,
        array|string|null $query,
        array             $payload,
        array             $headers,
        ?string           $ip
    ): void {
        HttpLog::create(compact(
            'name',
            'method',
            'scheme',
            'host',
            'port',
            'path',
            'query',
            'payload',
            'headers',
            'ip'
        ));
    }
}
