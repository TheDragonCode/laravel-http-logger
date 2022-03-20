<?php

declare(strict_types=1);

namespace DragonCode\LaravelHttpLogger\Casts;

use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Method implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return $value;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return Str::upper($value);
    }
}
