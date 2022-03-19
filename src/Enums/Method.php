<?php

declare(strict_types=1);

namespace DragonCode\LaravelHttpLogger\Enums;

enum Method: string
{
    case GET = 'GET';

    case HEAD = 'HEAD';

    case POST = 'POST';

    case PUT = 'PUT';

    case PATCH = 'PATCH';

    case OPTIONS = 'OPTIONS';

    case DELETE = 'DELETE';

    case CONNECT = 'CONNECT';

    case TRACE = 'TRACE';
}
