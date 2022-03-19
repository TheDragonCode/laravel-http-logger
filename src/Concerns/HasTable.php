<?php

declare(strict_types=1);

namespace DragonCode\LaravelHttpLogger\Concerns;

trait HasTable
{
    protected function getLogsConnectionName(): ?string
    {
        return config('logging.http.connection');
    }

    protected function getLogsTableName(): ?string
    {
        return config('logging.http.table');
    }
}
