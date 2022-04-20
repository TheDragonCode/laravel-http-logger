<?php

declare(strict_types=1);

namespace DragonCode\LaravelHttpLogger\Models;

use DragonCode\LaravelHttpLogger\Casts\Hide;
use DragonCode\LaravelHttpLogger\Casts\HideHeader;
use DragonCode\LaravelHttpLogger\Casts\Method;
use DragonCode\LaravelHttpLogger\Concerns\HasTable;
use DragonCode\Support\Facades\Http\Builder;
use DragonCode\Support\Http\Builder as HttpBuilder;
use Illuminate\Database\Eloquent\Model;

class HttpLog extends Model
{
    use HasTable;

    protected $fillable = [
        'name',
        'method',
        'scheme',
        'host',
        'port',
        'path',
        'query',
        'payload',
        'headers',
        'ip',
    ];

    protected $casts = [
        'method' => Method::class,

        'port' => 'int',

        'query'   => Hide::class,
        'payload' => Hide::class,
        'headers' => HideHeader::class,
    ];

    public function __construct(array $attributes = [])
    {
        $this->setConnection($this->getLogsConnectionName());
        $this->setTable($this->getLogsTableName());

        parent::__construct($attributes);
    }

    public function getFullUrlAttribute(): HttpBuilder
    {
        return Builder::same()
            ->withScheme($this->scheme)
            ->withHost($this->host)
            ->withPort($this->port)
            ->withPath($this->path)
            ->withQuery($this->query);
    }
}
