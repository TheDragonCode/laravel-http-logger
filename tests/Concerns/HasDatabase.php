<?php

declare(strict_types=1);

namespace Tests\Concerns;

use DragonCode\LaravelHttpLogger\Models\HttpLog;

trait HasDatabase
{
    protected function assertDatabaseLogsCount(int $count): void
    {
        $this->assertSame($count, HttpLog::query()->count());
    }

    protected function assertDatabaseHasRecord(string $method, string $name, string $path, int $expected = 1): void
    {
        $count = HttpLog::where(compact('method', 'name', 'path'))->count();

        $message = $method . ' ' . $path . ' ' . $name;

        $this->assertSame($expected, $count, $message);
    }
}
