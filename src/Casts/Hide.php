<?php

declare(strict_types=1);

namespace DragonCode\LaravelHttpLogger\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

class Hide implements CastsAttributes
{
    protected string $mask = '*';

    public function get($model, string $key, $value, array $attributes): array
    {
        return json_decode($value, true);
    }

    public function set($model, string $key, $value, array $attributes): string
    {
        if ($this->enabled()) {
            $value = $this->process((array) $value);
        }

        return json_encode((array) $value, JSON_NUMERIC_CHECK);
    }

    protected function process(array $values): array
    {
        foreach ($values as $k => &$val) {
            if (is_array($val)) {
                $val = $this->process($val);

                continue;
            }

            if ($this->toHide($k)) {
                $val = $this->hide($val);
            }
        }

        return $values;
    }

    protected function toHide(mixed $key): bool
    {
        return in_array(Str::lower((string) $key), $this->hides(), true);
    }

    #[Pure]
    protected function hide(mixed $value): string
    {
        $length = Str::length($value);

        return str_pad('', $length, $this->mask);
    }

    protected function enabled(): bool
    {
        return (bool) config('http-logger.hide.enabled', true);
    }

    protected function hides(): array
    {
        return config('http-logger.hide.keys', []);
    }
}
