<?php

declare(strict_types=1);

namespace DragonCode\LaravelHttpLogger\Http\Middleware;

use Closure;
use DragonCode\LaravelHttpLogger\Services\Logger;
use Illuminate\Http\Request;

class HttpLogMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($this->enabled()) {
            Logger::save($request);
        }

        return $next($request);
    }

    protected function enabled(): bool
    {
        return config('logging.http.enabled', true);
    }
}
